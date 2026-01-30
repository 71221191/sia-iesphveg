<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class TreasuryController extends Controller
{
    public function index(Request $request)
    {
        // Filtramos por estado (por defecto pendientes)
        $status = $request->input('status', 'pending');

        $payments = Payment::with('person') // Traemos al alumno
            ->where('status', $status)
            ->orderBy('created_at', 'asc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Treasury/Index', [
            'payments' => $payments,
            'currentStatus' => $status
        ]);
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:255',
        ]);

        $payment->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        // --- LA MAGIA: Limpiar el caché de matrícula del alumno ---
        // Esto hace que cuando el alumno refresque su matrícula, el sistema recalcule
        // y vea que ya pagó, desbloqueándole los cursos al instante.
        $period = \App\Models\AcademicPeriod::where('status', 'open')->first();
        if ($period) {
            Cache::forget("eligible_courses_{$payment->person_id}_{$period->id}");
        }

        return redirect()->back()->with('success', 'Pago procesado correctamente.');
    }
}
