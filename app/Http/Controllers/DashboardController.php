<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;

class DashboardController extends Controller
{
    // Cambiamos __invoke por index para coincidir con tus rutas
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $studentInfo = null;

        if ($user->hasRole('estudiante') && $user->person) {
            $person = $user->person;

            // 1. Buscamos la ÚLTIMA matrícula para saber qué estudia actualmente
            // Asegúrate de que en Person.php tengas la relación: public function enrollments() { return $this->hasMany(Enrollment::class); }
            $ultimaMatricula = $person->enrollments()
                ->with(['studyPlan.program']) // Cargar Plan y Programa
                ->latest()
                ->first();

            // 2. Buscamos la ÚLTIMA ficha socioeconómica
            // Asegúrate de que en Person.php tengas: public function socioeconomicFiles() { return $this->hasMany(SocioeconomicFile::class); }
            $ultimaFicha = $person->socioeconomicFiles()
                ->latest()
                ->first();

            // 3. Armamos el objeto de datos blindado contra nulos
            $studentInfo = [
                'names'             => $person->names,
                'last_name_p'       => $person->last_name_p,
                'dni'               => $person->dni,
                
                // Datos Académicos (Vienen de la matrícula)
                'program_name'      => $ultimaMatricula?->studyPlan?->program?->name ?? 'Sin carrera asignada',
                'plan_name'         => $ultimaMatricula?->studyPlan?->name ?? 'Sin plan',
                'cycle'             => $ultimaMatricula?->cycle ?? '-',
                'section_label'     => $ultimaMatricula?->section_label ?? '-',
                'approval_resolution' => $ultimaMatricula?->approval_resolution ?? 'Pendiente',

                // Datos Socioeconómicos (Vienen de la ficha)
                'scholarship_resolution' => $ultimaFicha?->scholarship_type_id ? 'Beca Asignada' : 'No aplica', // O cargar relación scholarshipType
                'has_children'           => (bool)($ultimaFicha?->has_children ?? false),
                'children_count'         => $ultimaFicha?->children_count ?? 0,
                
                // Datos Personales
                'has_work'               => (bool)$person->has_work,
                'work_type'              => $person->work_type ?? 'No especificado',
                'project_name'           => $person->project_name ?? 'Sin proyecto',
            ];
        }

        return Inertia::render('Dashboard', [
            // No necesitas enviar 'auth.user' aquí porque el Middleware HandleInertiaRequests ya lo hace globalmente
            'student_info' => $studentInfo,
        ]);
    }
}