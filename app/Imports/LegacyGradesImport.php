<?php

namespace App\Imports;

use App\Models\{Person, StudyProgram, StudyPlan, Course, AcademicPeriod, Enrollment, EnrollmentDetail, User, IdentityDocumentType, EnrollmentType, Shift};
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\{OnEachRow, WithHeadingRow, WithChunkReading, WithEvents};
use Maatwebsite\Excel\Events\{BeforeImport, AfterImport};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\{Cache, Log, Hash};
use App\Traits\StandardizesAcademicData;

class LegacyGradesImport implements OnEachRow, WithHeadingRow, WithChunkReading, WithEvents
{
    use StandardizesAcademicData;

    public static $reporte = [
        'creados' => 0,
        'actualizados' => 0,
        'omitidos' => 0,
        'errores' => []
    ];

    private $importId;
    private $fixedPassword; // <--- AGREGADO

    public function __construct($importId)
    {
        $this->importId = $importId;
        // Calculamos la contraseña UNA sola vez para que vuele
        $this->fixedPassword = Hash::make('Cajamarca2025');
    }

    public function onRow(Row $row)
        {
            $rawData = $row->toArray();
            $data = [];
            foreach ($rawData as $key => $value) {
                $data[trim($key)] = $value;
            }

            $index = $row->getIndex();

            try {
                $dni = trim($data['numero_documento'] ?? $data['dni'] ?? $data['nro_documento'] ?? '');
                $cursoNombre = strtoupper(trim($data['curso'] ?? $data['asignatura'] ?? $data['unidad_didactica'] ?? ''));
                $nota = $data['promedio_vigesimal'] ?? $data['nota'] ?? $data['promedio'] ?? 0;

                if (empty($dni) || empty($cursoNombre)) {
                    self::$reporte['omitidos']++;
                    return;
                }

                // 4. ASEGURAR BÁSICOS (Esto se queda igual, está muy bien)
                $user = User::firstOrCreate(
                    ['username' => $dni],
                    [
                        'password' => $this->fixedPassword, // Usamos el hash rápido
                        'is_active' => true,
                        'must_change_password' => true
                    ]
                );

                // Asignar rol estudiante (para que puedan entrar)
                if (!$user->hasRole('estudiante')) {
                    $user->assignRole('estudiante');
                }

                // Aseguramos catálogos básicos (sin crear el Admin una y otra vez)
                IdentityDocumentType::firstOrCreate(['id' => 1], ['name' => 'DNI', 'short_name' => 'DNI']);
                EnrollmentType::firstOrCreate(['id' => 1], ['name' => 'REGULAR']);
                Shift::firstOrCreate(['id' => 1], ['name' => 'MAÑANA']);

                // 5. PERSONA (Vinculada al Usuario Nuevo)
                $person = Person::updateOrCreate(['dni' => $dni], [ // <--- CAMBIAR POR updateOrCreate
                    'user_id' => $user->id, // Esto forzará la actualización del ID correcto
                    'identity_document_type_id' => 1,
                    'names' => strtoupper(trim($data['nombres'] ?? 'SIN NOMBRE')),
                    'last_name_p' => strtoupper(trim($data['apellido_paterno'] ?? '')),
                    'last_name_m' => strtoupper(trim($data['apellido_materno'] ?? '')),
                    'gender' => 'M',
                    'birth_date' => '2000-01-01',
                    'nationality' => 'PERUANA' // Agregado para evitar error de campo requerido
                ]);

                // 6. PERIODO
                $period = AcademicPeriod::firstOrCreate(['name' => trim($data['periodo'] ?? 'HISTORICO')], [
                    'start_date' => '2010-01-01', 'end_date' => '2010-01-01', 'status' => 'closed'
                ]);

                // 7. PROGRAMA Y PLAN (¡AQUÍ USAMOS EL COLADOR!)
                // Usamos el colador para que limpie ":" y separe paréntesis si existen
                $info = $this->extraerInfoPrograma($data['programa'] ?? '');

                $program = StudyProgram::firstOrCreate(['name' => $info['programa']]);

                $plan = StudyPlan::firstOrCreate(
                    [
                        'study_program_id' => $program->id,
                        'resolution_code' => $info['resolucion']
                    ],
                    [
                        'name' => 'Plan ' . $info['resolucion'],
                        'evaluation_type' => 'vigesimal',
                        'valid_from_year' => 2000
                    ]
                );

                // 8. CURSO (Vinculado al plan que detectó el colador)
                $course = Course::firstOrCreate(
                    ['study_plan_id' => $plan->id, 'name' => $cursoNombre, 'cycle' => $data['ciclo'] ?? 'I'],
                    ['code' => 'L' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT), 'credits' => 0, 'is_legacy' => true]
                );

                // 9. MATRÍCULA
                $enrollment = Enrollment::firstOrCreate([
                    'person_id' => $person->id,
                    'academic_period_id' => $period->id,
                    'study_plan_id' => $plan->id,
                ], [
                    'cycle' => $data['ciclo'] ?? 'I',
                    'enrollment_type_id' => 1, 'shift_id' => 1, 'section_label' => 'A'
                ]);

                // 10. NOTA
                $detail = EnrollmentDetail::updateOrCreate([
                    'enrollment_id' => $enrollment->id,
                    'course_id' => $course->id,
                ], [
                    'final_score_numeric' => is_numeric($nota) ? $nota : 0,
                    'is_legacy' => true,
                    'status' => ($nota >= 11) ? 'approved' : 'failed'
                ]);

                if ($detail->wasRecentlyCreated) self::$reporte['creados']++;
                else self::$reporte['actualizados']++;

                if ($index % 20 == 0) {
                    Cache::put("import_progress_{$this->importId}", $index, 600);
                }

            } catch (\Exception $e) {
                Log::error("ERROR EN FILA {$index} (DNI: {$dni}): " . $e->getMessage());
                self::$reporte['errores'][] = "Fila {$index}: " . $e->getMessage();
            }
        }

    public function registerEvents(): array {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();
                Cache::put("import_total_{$this->importId}", reset($totalRows), 600);
            },
            AfterImport::class => function(AfterImport $event) {
                Cache::put("import_progress_{$this->importId}", 'COMPLETO', 600);
            },
        ];
    }

    public function chunkSize(): int { return 200; } // Bajamos el tamaño del bloque para que PHP respire
}
