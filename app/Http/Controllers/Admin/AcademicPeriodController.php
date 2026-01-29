<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule; // Para la validación 'unique'
use Illuminate\Support\Facades\Log; // Para depuración
use Illuminate\Support\Facades\DB; // Para transacciones
use Inertia\Response;

class AcademicPeriodController extends Controller
{
    /**
     * Muestra la lista de períodos académicos.
     */
    public function index()
    {
        Log::info('[AcademicPeriodController@index] Cargando lista de períodos académicos.');
        $academicPeriods = AcademicPeriod::orderBy('start_date', 'desc')->paginate(10);

        return Inertia::render('Admin/AcademicPeriods/Index', [
            'academicPeriods' => $academicPeriods,
            'flash' => [ // Asegúrate de que 'flash' siempre sea un objeto
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo período académico.
     */
    public function create()
    {
        Log::info('[AcademicPeriodController@create] Mostrando formulario de creación de período académico.');
        return Inertia::render('Admin/AcademicPeriods/Create');
    }

    /**
     * Guarda un nuevo período académico en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info('[AcademicPeriodController@store] Intentando guardar nuevo período académico.');
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_periods,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => ['required', Rule::in(['planning', 'open', 'closed'])], // planificado, abierto, cerrado
        ]);

        AcademicPeriod::create($validated);
        Log::info('[AcademicPeriodController@store] Período académico creado con éxito: ' . $validated['name']);

        return redirect()->route('admin.academic_periods.index')
                         ->with('success', 'Período académico creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un período académico existente.
     */
    public function edit(AcademicPeriod $academicPeriod)
    {
        Log::info('[AcademicPeriodController@edit] Editando período académico ID: ' . $academicPeriod->id);
        return Inertia::render('Admin/AcademicPeriods/Edit', [
            'academicPeriod' => $academicPeriod,
        ]);
    }

    /**
     * Actualiza un período académico existente en la base de datos.
     */
    public function update(Request $request, AcademicPeriod $academicPeriod)
    {
        Log::info('[AcademicPeriodController@update] Intentando actualizar período académico ID: ' . $academicPeriod->id);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('academic_periods')->ignore($academicPeriod->id),
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => ['required', Rule::in(['planning', 'open', 'closed'])],
        ]);

        $academicPeriod->update($validated);
        Log::info('[AcademicPeriodController@update] Período académico ID: ' . $academicPeriod->id . ' actualizado con éxito.');

        return redirect()->route('admin.academic_periods.index')
                         ->with('success', 'Período académico actualizado exitosamente.');
    }

    /**
     * Elimina un período académico.
     */
    public function destroy(AcademicPeriod $academicPeriod)
    {
        Log::info('[AcademicPeriodController@destroy] Intentando eliminar período académico ID: ' . $academicPeriod->id);
        // Implementar RF-060 Integridad de Cierre de Periodo aquí si hay matrículas activas
        // Por ahora, solo eliminar.
        $academicPeriod->delete();
        Log::info('[AcademicPeriodController@destroy] Período académico ID: ' . $academicPeriod->id . ' eliminado.');

        return redirect()->route('admin.academic_periods.index')
                         ->with('success', 'Período académico eliminado exitosamente.');
    }

    /**
     * Acción para "Abrir" un período académico.
     * Cierra cualquier otro período "open" antes de abrir el nuevo.
     */
    public function openPeriod(AcademicPeriod $academicPeriod)
    {
        Log::info('[AcademicPeriodController@openPeriod] Solicitud para abrir período académico ID: ' . $academicPeriod->id);
        try {
            DB::transaction(function () use ($academicPeriod) {
                // Cerrar cualquier otro período que esté 'open'
                AcademicPeriod::where('status', 'open')
                              ->where('id', '!=', $academicPeriod->id)
                              ->update(['status' => 'closed']);
                Log::info('[AcademicPeriodController@openPeriod] Otros períodos abiertos cerrados.');

                // Abrir el período seleccionado
                $academicPeriod->update(['status' => 'open']);
                Log::info('[AcademicPeriodController@openPeriod] Período académico ID: ' . $academicPeriod->id . ' ahora está ABIERTO.');
            });

            return redirect()->route('admin.academic_periods.index')
                             ->with('success', "El período '{$academicPeriod->name}' ha sido abierto y otros períodos han sido cerrados.");
        } catch (\Exception $e) {
            Log::error('[AcademicPeriodController@openPeriod] Error al intentar abrir período ID: ' . $academicPeriod->id . ' - ' . $e->getMessage());
            return back()->with('error', 'Error al abrir el período: ' . $e->getMessage());
        }
    }
}
