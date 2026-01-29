<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Buscador por DNI o Apellidos
        $search = $request->input('search');

        $students = Person::query()
            ->when($search, function ($query, $search) {
                $query->where('dni', 'like', "%{$search}%")
                      ->orWhere('last_name_p', 'like', "%{$search}%")
                      ->orWhere('names', 'like', "%{$search}%");
            })
            ->orderBy('last_name_p')
            ->paginate(15) // Paginación para no saturar con los 14k
            ->withQueryString();

        return Inertia::render('Admin/Students/Index', [
            'students' => $students,
            'filters' => $request->only(['search'])
        ]);
    }

    public function show($id)
    {
        // Traemos al alumno con toda su historia académica
        $student = Person::with([
            'enrollments.academicPeriod',
            'enrollments.details.course',
            'enrollments.studyPlan.program'
        ])->findOrFail($id);

        return Inertia::render('Admin/Students/Show', [
            'student' => $student
        ]);
    }
}
