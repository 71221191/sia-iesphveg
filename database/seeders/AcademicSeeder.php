<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyProgram;
use App\Models\StudyPlan;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiamos los constraints para poder vaciar si es necesario
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. REGISTRO DE PROGRAMAS (CARRERAS)
        // Usamos firstOrCreate para que si ya existe por un Excel, no lo duplique
        $inicial = StudyProgram::firstOrCreate(
            ['name' => 'EDUCACIÓN INICIAL'],
            ['short_name' => 'INICIAL']
        );

        $matematica = StudyProgram::firstOrCreate(
            ['name' => 'EDUCACIÓN SECUNDARIA, ESPECIALIDAD MATEMÁTICA'],
            ['short_name' => 'MATEMÁTICA']
        );

        // 2. REGISTRO DE PLANES (RVM)
        // Usamos el ID que la base de datos asignó automáticamente arriba ($inicial->id)
        $planInicial = StudyPlan::firstOrCreate(
            [
                'study_program_id' => $inicial->id,
                'resolution_code' => 'RVM 163-2019-MINEDU'
            ],
            [
                'name' => 'Plan RVM 163-2019-MINEDU',
                'evaluation_type' => 'competency',
                'valid_from_year' => 2019,
                'is_active' => true
            ]
        );

        $planMate = StudyPlan::firstOrCreate(
            [
                'study_program_id' => $matematica->id,
                'resolution_code' => 'RVM 076-2020-MINEDU'
            ],
            [
                'name' => 'Plan RVM 076-2020-MINEDU',
                'evaluation_type' => 'competency',
                'valid_from_year' => 2020,
                'is_active' => true
            ]
        );

        // 3. REGISTRO DE CURSOS
        // Vinculamos usando los IDs de los planes que acabamos de crear
        $courses = [
            // Cursos para Inicial
            [
                'study_plan_id' => $planInicial->id,
                'code' => 'IN01',
                'name' => 'LECTURA Y ESCRITURA EN LA EDUCACIÓN SUPERIOR',
                'cycle' => 'I',
                'credits' => 3.0,
                'type' => 'specific'
            ],
            // Cursos para Matemática
            [
                'study_plan_id' => $planMate->id,
                'code' => 'MT01',
                'name' => 'LECTURA Y ESCRITURA EN LA EDUCACIÓN SUPERIOR',
                'cycle' => 'I',
                'credits' => 3.0,
                'type' => 'specific'
            ],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(
                ['study_plan_id' => $course['study_plan_id'], 'name' => $course['name']],
                $course
            );
        }

        // 4. PERIODO ACADÉMICO
        DB::table('academic_periods')->updateOrInsert(
            ['name' => '2025-I'],
            [
                'start_date' => '2025-03-01',
                'end_date' => '2025-07-31',
                'status' => 'open'
            ]
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
