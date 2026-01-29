<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SocioeconomicFile;
use App\Models\Person;
use App\Models\AcademicPeriod; // <--- Importante: Agregamos esto

class SocioeconomicController extends Controller
{
    /**
     * Muestra el formulario (Wizard)
     */
    public function create()
    {
        $user = Auth::user();

        // 1. Obtenemos a la persona
        $person = Person::where('user_id', $user->id)->first();

        if (!$person) {
            return redirect()->route('dashboard')->with('error', 'No se encontraron datos personales.');
        }

        // 2. LÓGICA DE ACTUALIZACIÓN SEMESTRAL (Aquí va lo que preguntaste)
        // ------------------------------------------------------------------

        // A. Buscamos cuál es el periodo vigente (Ej: 2025-II)
        $periodoActual = AcademicPeriod::where('status', 'open')->first();

        // Si no hay periodo abierto, no se puede llenar ficha (o usamos el último)
        if (!$periodoActual) {
            return redirect()->route('dashboard')->with('error', 'No hay periodo académico activo para matrícula.');
        }

        // B. Buscamos si YA tiene ficha para ESTE periodo
        $fichaParaPrellenar = SocioeconomicFile::where('person_id', $person->id)
            ->where('academic_period_id', $periodoActual->id)
            ->first();

        // C. Si NO tiene ficha de hoy, buscamos la del ciclo ANTERIOR para copiar datos
        if (!$fichaParaPrellenar) {
            $fichaParaPrellenar = SocioeconomicFile::where('person_id', $person->id)
                ->latest() // La última que haya hecho en su vida
                ->first();
        }
        // ------------------------------------------------------------------

        // 3. Cargamos Catálogos (Cache simple)
        $catalogs = [
            'identity_types' => DB::table('identity_document_types')->select('id', 'name')->get(),
            'civil_statuses' => DB::table('marital_statuses')->select('id', 'name')->get(),
            'languages'      => DB::table('languages')->select('id', 'name')->orderBy('name')->get(),
            'ethnicities'    => DB::table('ethnicities')->select('id', 'name')->get(),
            'disabilities'   => DB::table('disability_types')->select('id', 'name')->get(),
            'scholarships'   => DB::table('scholarship_types')->select('id', 'name')->get(),
            'ubigeos'        => DB::table('ubigeos')
                                ->select('id', 'code', 'district', 'province')
                                ->where('department', 'CAJAMARCA') // Optimización temporal
                                ->get()
                                ->map(fn($u) => ['id' => $u->id, 'label' => "{$u->district} - {$u->province}"]),
        ];

        // 4. Preparamos la data para el formulario (Hydration)
        $formData = [
            // Paso 1: Identidad (Datos fijos de la persona)
            'names' => $person->names,
            'last_name_p' => $person->last_name_p,
            'last_name_m' => $person->last_name_m,
            'dni' => $person->dni,
            'birth_date' => $person->birth_date,
            'gender' => $person->gender,
            'marital_status_id' => $person->marital_status_id,
            'native_language_id' => $person->native_language_id,
            'ethnicity_id' => $person->ethnicity_id,

            // Paso 2: Ubicación
            'phone' => $person->phone,
            'email' => $user->email,
            'address' => $person->address,
            'ubigeo_residence_id' => $person->ubigeo_residence_id,

            // Paso 3: Salud
            'has_disability' => (bool)$person->has_disability,
            'disability_type_id' => $person->disability_type_id,
            'conadis_number' => $person->conadis_number,

            // Paso 4: Socioeconómico (Pre-llenado inteligente)
            // Si encontramos ficha (actual o antigua), usamos esos datos. Si no, vacíos.
            'has_children' => $fichaParaPrellenar ? (bool)$fichaParaPrellenar->has_children : false,
            // --- CAMBIO AQUÍ EN EL formData PARA children_count ---
            'children_count' => $fichaParaPrellenar && $fichaParaPrellenar->has_children
                                ? ($fichaParaPrellenar->children_count ?: 1)
                                : null,
            'scholarship_type_id' => $fichaParaPrellenar ? $fichaParaPrellenar->scholarship_type_id : null,
            'work_status' => (bool)$person->has_work,
            'work_type' => $person->work_type,
        ];

        return Inertia::render('socioeconomic/Create', [
            'initialData' => $formData,
            'catalogs' => $catalogs,
            'periodo' => $periodoActual->name // Para mostrar "Ficha 2025-II" en el título
        ]);
    }

    /**
     * Guarda la ficha socioeconómica y actualiza datos del alumno.
     */
    public function store(Request $request)
    {
        Log::info('[SocioeconomicController@store] -- INICIO del guardado de ficha.');

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $person = Person::where('user_id', $user->id)->firstOrFail();

        // 1. VALIDACIÓN ESTRICTA (Reglas de Negocio)
        $validated = $request->validate([
            // ... (tus reglas de validación se quedan igual) ...
            'marital_status_id' => 'required|exists:marital_statuses,id',
            'native_language_id' => 'required|exists:languages,id',
            'ethnicity_id' => 'required|exists:ethnicities,id',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email',
            'address' => 'required|string|max:255',
            'ubigeo_residence_id' => 'required|exists:ubigeos,id',
            'has_disability' => 'required|boolean',
            'disability_type_id' => 'nullable|required_if:has_disability,true|exists:disability_types,id',
            'conadis_number' => 'nullable|string|max:50',
            'work_status' => 'required|boolean',
            'work_type' => 'nullable|required_if:work_status,true|string|max:100',
            'has_children' => 'required|boolean',
            'children_count' => 'nullable|required_if:has_children,true|integer|min:1',
            'scholarship_type_id' => 'nullable|exists:scholarship_types,id',
            'confirmacion_jurada' => 'accepted'
        ]);

        try {
            DB::transaction(function () use ($user, $person, $validated) {
                Log::info('[SocioeconomicController@store] Iniciando transacción DB.');

                // 2. ACTUALIZAR EMAIL DEL USUARIO (Si cambió)
                if ($user->email !== $validated['email']) {
                    $user->email = $validated['email'];
                    $user->save();
                    Log::info('[SocioeconomicController@store] Email de usuario actualizado.');
                }

                // 3. ACTUALIZAR DATOS DE LA PERSONA (Person)
                $person->update([
                    'marital_status_id' => $validated['marital_status_id'],
                    'native_language_id' => $validated['native_language_id'],
                    'ethnicity_id' => $validated['ethnicity_id'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'ubigeo_residence_id' => $validated['ubigeo_residence_id'],
                    'has_disability' => $validated['has_disability'],
                    'disability_type_id' => $validated['has_disability'] ? $validated['disability_type_id'] : null,
                    'conadis_number' => $validated['has_disability'] ? $validated['conadis_number'] : null,
                    'has_work' => $validated['work_status'],
                    'work_type' => $validated['work_status'] ? $validated['work_type'] : null,
                ]);
                Log::info('[SocioeconomicController@store] Datos de Person actualizados para ID: ' . $person->id);


                // 4. CREAR/ACTUALIZAR LA FICHA (SocioeconomicFile)
                $periodoActual = AcademicPeriod::where('status', 'open')->firstOrFail();
                $socioeconomicFile = SocioeconomicFile::updateOrCreate(
                    [
                        'person_id' => $person->id,
                        'academic_period_id' => $periodoActual->id
                    ],
                    [
                        'has_children' => $validated['has_children'],
                        'children_count' => $validated['has_children'] ? $validated['children_count'] : 0,
                        'scholarship_type_id' => $validated['scholarship_type_id'],
                        'is_validated' => true, // Auto-validado porque es declaración jurada
                        'updated_at' => now()
                    ]
                );
                Log::info('[SocioeconomicController@store] Ficha Socioeconómica (ID ' . $socioeconomicFile->id . ') Creada/Actualizada. is_validated: ' . ($socioeconomicFile->is_validated ? 'TRUE' : 'FALSE'));

            }); // Fin de la transacción

            Log::info('[SocioeconomicController@store] Transacción de guardado completada. Redirigiendo a dashboard.');
            return redirect()->route('dashboard')->with('success', '¡Ficha actualizada correctamente! Ya estás habilitado.');

        } catch (\Exception $e) {
            Log::error('[SocioeconomicController@store] ERROR al guardar la ficha: ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine());
            return back()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }
}
