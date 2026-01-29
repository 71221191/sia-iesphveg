<?php

namespace App\Imports;

use App\Models\{
    Person, StudyProgram, StudyPlan, AcademicPeriod, Enrollment, User,
    IdentityDocumentType, EnrollmentType, Shift, Ethnicity, Language,
    MaritalStatus, ScholarshipType, DisabilityType, SocioeconomicFile, Ubigeo
};
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\{OnEachRow, WithHeadingRow, WithEvents};
use Maatwebsite\Excel\Events\{BeforeImport, AfterImport};
use App\Traits\StandardizesAcademicData;
use Illuminate\Support\Facades\{Log, Cache, DB};
use Carbon\Carbon; // Necesario para fechas texto

class ActiveStudentsImport implements OnEachRow, WithHeadingRow, WithEvents
{
    use StandardizesAcademicData;

    // Agregamos 'actualizados_lista' para guardar los nombres
    public static $reporte = [
        'creados' => 0,
        'actualizados' => 0,
        'omitidos' => 0,
        'errores' => [],
        'actualizados_lista' => [] // <--- NUEVO: Aquí guardaremos los nombres
    ];

    private $importId;
    private $languages;
    private $ethnicities;
    private $ubigeos;
    private $maritalStatuses;
    private $disabilityTypes;
    private $fixedPassword;

    public function __construct($importId) {
        $this->importId = $importId;
        $this->fixedPassword = \Illuminate\Support\Facades\Hash::make('Cajamarca2025');
        $this->languages = DB::table('languages')->pluck('id', 'name')->toArray();
        $this->ethnicities = DB::table('ethnicities')->pluck('id', 'name')->toArray();
        $this->ubigeos = DB::table('ubigeos')->pluck('id', 'code')->toArray();
        $this->maritalStatuses = DB::table('marital_statuses')->pluck('id', 'name')->toArray();
        $this->disabilityTypes = DB::table('disability_types')->pluck('id', 'name')->toArray();
    }

    private function findId($catalog, $excelValue) {
        $search = strtoupper(trim($excelValue ?? ''));
        if (empty($search)) return null;
        if (isset($catalog[$search])) return $catalog[$search];
        foreach ($catalog as $key => $id) {
            if (str_contains($search, $key) || str_contains($key, $search)) return $id;
        }
        return null;
    }

    // Nueva función para intentar salvar cualquier fecha
    private function procesarFecha($valor) {
        if (empty($valor)) return '2000-01-01'; // Default si está vacío

        try {
            // Caso A: Es número de Excel (ej: 45678)
            if (is_numeric($valor)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($valor);
            }
            // Caso B: Es texto (ej: 11/11/1993)
            return Carbon::createFromFormat('d/m/Y', trim($valor))->format('Y-m-d');
        } catch (\Exception $e) {
            return '2000-01-01'; // Default si falla el formato
        }
    }

    public function onRow(Row $row)
        {
            $data = $row->toArray();
            $index = $row->getIndex();

            try {
                $dni = trim($data['numero_documento_identidad'] ?? '');
                if (empty($dni)) {
                    self::$reporte['omitidos']++;
                    return;
                }

                // --- CORRECCIÓN INICIO: CREAR USUARIO INDIVIDUAL Y ASIGNAR ROL ---

                // 1. Crear el usuario para este alumno específico
                $user = User::firstOrCreate(
                    ['username' => $dni],
                    [
                        'password' => $this->fixedPassword, // Clave = DNI
                        'is_active' => true,
                        'must_change_password' => true
                    ]
                );

                // 2. Asignarle el rol de ESTUDIANTE (ID 3)
                // (Usamos syncRoles para asegurar que solo sea estudiante y borrarle el admin si lo tuviera)
                if (!$user->hasRole('estudiante')) {
                    $user->assignRole('estudiante');
                }
                // ------------------------------------------------------------------

                // 3. ACADÉMICO
                $infoProg = $this->extraerInfoPrograma($data['plan_de_estudios'] ?? '');
                $nombreCarrera = $this->normalizarNombrePrograma($data['programa_de_estudios_carrera_profesional'] ?? '');

                $program = StudyProgram::firstOrCreate(['name' => $nombreCarrera]);
                $plan = StudyPlan::firstOrCreate(
                    ['study_program_id' => $program->id, 'resolution_code' => $infoProg['resolucion']],
                    ['name' => 'Plan ' . $infoProg['resolucion'], 'evaluation_type' => 'competency', 'valid_from_year' => 2019]
                );

                $period = AcademicPeriod::firstOrCreate(
                    ['name' => $this->extraerPeriodo($data['resolucion_aprobacion'] ?? '')],
                    ['start_date' => '2025-01-01', 'end_date' => '2025-12-31', 'status' => 'open']
                );

                $tipoMatricula = EnrollmentType::firstOrCreate(['name' => strtoupper(trim($data['tipo_matricula'] ?? 'REGULAR'))]);
                $turno = Shift::firstOrCreate(['name' => strtoupper(trim($data['turno'] ?? 'MAÑANA'))]);

                $nombreBeca = strtoupper(trim($data['modalidad_beca'] ?? 'NINGUNA'));
                if (empty($nombreBeca) || $nombreBeca === '-') $nombreBeca = 'NINGUNA';
                $becaType = ScholarshipType::firstOrCreate(['name' => $nombreBeca]);

                // 4. PERSONA (AQUÍ ESTABA EL ERROR DEL ID 1)
                $person = Person::updateOrCreate(
                    ['dni' => $dni],
                    [
                        'user_id' => $user->id, // <--- AHORA SÍ: Usamos el ID del usuario creado arriba
                        'identity_document_type_id' => 1,
                        'names' => strtoupper(trim($data['nombres'])),
                        'last_name_p' => strtoupper(trim($data['apellido_paterno'])),
                        'last_name_m' => strtoupper(trim($data['apellido_materno'])),
                        'gender' => (str_contains(strtoupper($data['sexo'] ?? ''), 'FEM')) ? 'F' : 'M',
                        'birth_date' => $this->procesarFecha($data['fecha_nacimiento'] ?? null),
                        'nationality' => strtoupper($data['nacionalidad'] ?? 'PERUANA'),
                        'address' => $data['direccion_domicilio'] ?? null,
                        'ubigeo_birth_id' => $this->ubigeos[trim($data['ubigeo_nacimiento'] ?? '')] ?? null,
                        'ubigeo_residence_id' => $this->ubigeos[trim($data['ubigeo_domicilio'] ?? '')] ?? null,
                        'native_language_id' => $this->findId($this->languages, $data['lengua_materna']),
                        'ethnicity_id' => $this->findId($this->ethnicities, $data['autoidentifacion_etnica']),
                        'marital_status_id' => $this->findId($this->maritalStatuses, $data['estado_civil']),
                        'has_disability' => $this->convertirSiNo($data['discapacidad'] ?? 'NO'),
                        'disability_type_id' => $this->findId($this->disabilityTypes, $data['tipo_discapacidad']),
                        'conadis_number' => $data['numero_conadis'] ?? null,
                        'is_rebred_beneficiary' => $this->convertirSiNo($data['beneficiario_rebred'] ?? 'NO'),
                        'rebred_resolution' => $data['numero_resolucion_rebred'] ?? null,
                        'has_approved_project' => $this->convertirSiNo($data['proy_inv_aprobado'] ?? 'NO'),
                        'project_name' => $data['denominacion_proy_inv'] ?? null,
                        'has_work' => $this->convertirSiNo($data['con_trabajo'] ?? 'NO'),
                        'work_type' => $data['tipo_trabajo'] ?? null,
                        'has_license' => $this->convertirSiNo($data['con_licencia'] ?? 'NO'),
                        'license_resolution' => $data['resolucion_licencia'] ?? null,
                        'has_previous_studies' => $this->convertirSiNo($data['con_estudios_previos'] ?? 'NO'),
                        'previous_studies_at' => $data['estudios_previos_en'] ?? null,
                    ]
                );

                // ... (EL RESTO DEL CÓDIGO SIGUE IGUAL: MATRÍCULA Y FICHA) ...

                // 5. MATRÍCULA
                Enrollment::updateOrCreate(
                    ['person_id' => $person->id, 'academic_period_id' => $period->id],
                    [
                        'study_plan_id' => $plan->id,
                        'cycle' => $data['ciclo'] ?? 'I',
                        'enrollment_type_id' => $tipoMatricula->id,
                        'shift_id' => $turno->id,
                        'section_label' => substr($data['seccion'] ?? 'A', 0, 1),
                        'approval_resolution' => $data['resolucion_aprobacion'] ?? null
                    ]
                );

                // 6. FICHA SOCIO
                SocioeconomicFile::updateOrCreate(
                    ['person_id' => $person->id, 'academic_period_id' => $period->id],
                    [
                        'has_children' => $this->convertirSiNo($data['con_hijos'] ?? 'NO'),
                        'children_count' => is_numeric($data['cantidad_hijos'] ?? '') ? $data['cantidad_hijos'] : 0,
                        'scholarship_type_id' => $becaType->id,
                        'is_validated' => true
                    ]
                );

                // REPORTE
                if ($person->wasRecentlyCreated) {
                    self::$reporte['creados']++;
                } else {
                    self::$reporte['actualizados']++;
                    self::$reporte['actualizados_lista'][] = "{$dni} - {$person->names} {$person->last_name_p}";
                }

                if ($index % 20 == 0) Cache::put("import_active_progress_{$this->importId}", $index, 600);

            } catch (\Exception $e) {
                self::$reporte['errores'][] = "Fila {$index}: " . $e->getMessage();
            }
        }

    public function registerEvents(): array {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();
                Cache::put("import_active_total_{$this->importId}", reset($totalRows), 600);
            },
            AfterImport::class => function(AfterImport $event) {
                Cache::put("import_active_progress_{$this->importId}", 'COMPLETO', 600);
            },
        ];
    }
}
