<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Person;
use App\Models\AcademicPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading; // <--- IMPORTANTE PARA RENDIMIENTO
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class StudentsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    private $password;
    private $languages;
    private $ethnicities;
    private $ubigeos;
    private $maritalStatuses; // Nuevo
    private $disabilityTypes; // Nuevo
    private $periodId;

    public function __construct()
    {
        $this->password = Hash::make('Cajamarca2025');

        // Cargamos catálogos en memoria para velocidad
        $this->languages = DB::table('languages')->pluck('id', 'name')->toArray();
        $this->ethnicities = DB::table('ethnicities')->pluck('id', 'name')->toArray();
        $this->ubigeos = DB::table('ubigeos')->pluck('id', 'code')->toArray();
        $this->maritalStatuses = DB::table('marital_statuses')->pluck('id', 'name')->toArray();
        $this->disabilityTypes = DB::table('disability_types')->pluck('id', 'name')->toArray();

        $this->periodId = AcademicPeriod::where('status', 'open')->value('id');
    }

    // Función auxiliar para limpiar los "SI/NO" del Excel
    private function checkSi($value) {
        $clean = strtoupper(trim($value ?? ''));
        return str_starts_with($clean, 'SI');
    }

    // Función mágica para encontrar IDs buscando texto parcial (Ej: "SOLTERO(A)" -> "SOLTERO")
    private function findId($catalog, $excelValue) {
        $search = strtoupper(trim($excelValue ?? ''));
        if (empty($search)) return null;

        // Búsqueda exacta
        if (isset($catalog[$search])) return $catalog[$search];

        // Búsqueda aproximada (lenta pero necesaria para data sucia)
        foreach ($catalog as $key => $id) {
            $keyUpper = strtoupper($key);
            // Si el Excel dice "SOLTERO(A)" y la BD "SOLTERO", o viceversa
            if (str_contains($search, $keyUpper) || str_contains($keyUpper, $search)) {
                return $id;
            }
        }
        return null;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $dni = isset($row['numero_documento_identidad']) ? trim($row['numero_documento_identidad']) : null;
            if (!$dni) continue;

            // Verificación simple para saltar existentes (puedes optimizarla luego)
            //if (User::where('username', $dni)->exists()) continue;

            DB::transaction(function () use ($row, $dni) {
                // 1. USUARIO
                $user = User::firstOrCreate(['username' => $dni], [
                    'password' => $this->password,
                    'is_active' => true,
                    'must_change_password' => true,
                ]);
                $user->assignRole('estudiante');

                // 2. FECHA DE NACIMIENTO
                $rawDate = $row['fecha_nacimiento'];
                $birthDate = '2000-01-01'; // Default por si falla
                if (is_numeric($rawDate)) {
                    $birthDate = Carbon::instance(ExcelDate::excelToDateTimeObject($rawDate))->format('Y-m-d');
                } else if (!empty($rawDate)) {
                    try {
                        $birthDate = Carbon::createFromFormat('d/m/Y', trim($rawDate))->format('Y-m-d');
                    } catch (\Exception $e) { }
                }

                // 3. PROGRAMA Y PLAN
                $programName = strtoupper(trim($row['programa_de_estudios_carrera_profesional']));
                $planRes = trim($row['plan_de_estudios']);

                // Buscar ID o Crear (Cache simple)
                $progId = DB::table('study_programs')->where('name', $programName)->value('id');
                if (!$progId) {
                    $progId = DB::table('study_programs')->insertGetId(['name' => $programName, 'created_at' => now()]);
                }

                $planId = DB::table('study_plans')
                    ->where('study_program_id', $progId)
                    ->where('resolution_code', $planRes)
                    ->value('id');

                if (!$planId) {
                    $planId = DB::table('study_plans')->insertGetId([
                        'study_program_id' => $progId,
                        'name' => 'Plan ' . substr($planRes, -9), // Ej: 2019-MINEDU
                        'resolution_code' => $planRes,
                        'evaluation_type' => 'competency',
                        'valid_from_year' => 2025,
                        'is_active' => true
                    ]);
                }

                // 4. BÚSQUEDA DE IDs (CORRECCIÓN CRÍTICA)
                $maritalStatusId = $this->findId($this->maritalStatuses, $row['estado_civil']);
                $disabilityTypeId = $this->findId($this->disabilityTypes, $row['tipo_discapacidad']);
                // Ojo: Para Lengua y Etnia usamos el helper también para evitar errores de mayúsculas
                $langId = $this->findId($this->languages, $row['lengua_materna']) ?? 10; // 10=Castellano default
                $ethId = $this->findId($this->ethnicities, $row['autoidentifacion_etnica']) ?? 7; // 7=Mestizo default


                $person = Person::updateOrCreate(['dni' => $dni], [
                    'user_id' => $user->id,
                    'identity_document_type_id' => 1,
                    'dni' => $dni,
                    'names' => trim($row['nombres']),
                    'last_name_p' => trim($row['apellido_paterno']),
                    'last_name_m' => trim($row['apellido_materno']),
                    'gender' => (str_starts_with(strtoupper(trim($row['sexo'] ?? '')), 'FEM')) ? 'F' : 'M',
                    'birth_date' => $birthDate,
                    'nationality' => $row['nacionalidad'] ?? 'PERUANA',
                    'address' => $row['direccion_domicilio'] ?? 'No especificado',
                    'ubigeo_birth_id' => $this->ubigeos[trim($row['ubigeo_nacimiento'] ?? '')] ?? null,
                    'ubigeo_residence_id' => $this->ubigeos[trim($row['ubigeo_domicilio'] ?? '')] ?? null,


                    'native_language_id' => $langId,
                    'ethnicity_id' => $ethId,
                    'marital_status_id' => $maritalStatusId,

                    'has_disability' => $this->checkSi($row['discapacidad'] ?? 'NO'),
                    'disability_type_id' => $disabilityTypeId,

                    'has_license' => $this->checkSi($row['con_licencia'] ?? 'NO'),
                    'is_rebred_beneficiary' => $this->checkSi($row['beneficiario_rebred'] ?? 'NO'),
                    'has_approved_project' => $this->checkSi($row['proy_inv_aprobado'] ?? 'NO'),
                    'project_name' => $row['denominacion_proy_inv'],
                    'has_work' => $this->checkSi($row['con_trabajo'] ?? 'NO'),
                    'work_type' => $row['tipo_trabajo'],
                ]);

                // 6. MATRÍCULA
                if ($this->periodId) {
                    $enrollName = strtoupper(trim($row['tipo_matricula'] ?? 'REGULAR'));
                    // Truco: Cachear esto sería mejor, pero por ahora funciona
                    $enrollTypeId = DB::table('enrollment_types')->where('name', $enrollName)->value('id');
                    if (!$enrollTypeId) {
                        $enrollTypeId = DB::table('enrollment_types')->insertGetId(['name' => $enrollName]);
                    }

                    DB::table('enrollments')->insert([
                        'person_id' => $person->id,
                        'academic_period_id' => $this->periodId,
                        'study_plan_id' => $planId,
                        'cycle' => $row['ciclo'] ?? 'I',
                        'enrollment_type_id' => $enrollTypeId,
                        'shift_id' => (str_starts_with(strtoupper(trim($row['turno'] ?? '')), 'TAR')) ? 2 : 1,
                        'section_label' => $row['seccion'] ?? 'A',
                        'approval_resolution' => $row['resolucion_aprobacion'],
                        'created_at' => now(),
                    ]);

                    DB::table('socioeconomic_files')->insert([
                        'person_id' => $person->id,
                        'academic_period_id' => $this->periodId,
                        'has_children' => $this->checkSi($row['con_hijos'] ?? 'NO'),
                        'children_count' => is_numeric($row['cantidad_hijos'] ?? 0) ? ($row['cantidad_hijos'] ?? 0) : 0,
                        'scholarship_type_id' => ($this->checkSi($row['con_beca'] ?? 'NO')) ? 1 : 3, // 1=Beca, 3=Ninguna
                        'is_validated' => true,
                        'created_at' => now(),
                    ]);
                }
            });
        }
    }

    // Configuración para leer de 1000 en 1000 y no colapsar memoria
    public function chunkSize(): int
    {
        return 1000;
    }
}
