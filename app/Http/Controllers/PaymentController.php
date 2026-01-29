<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        $person = Person::where('user_id', Auth::id())->firstOrFail();

        // Obtenemos los pagos del alumno ordenados por el más reciente
        $payments = Payment::where('person_id', $person->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Payments/Index', [
            'payments' => $payments
        ]);
    }

    public function store(Request $request)
    {
        $person = Person::where('user_id', Auth::id())->firstOrFail();

        // VALIDACIÓN PROFESIONAL
        $request->validate([
            'operation_number' => 'required|string|unique:payments,operation_number',
            'amount' => 'required|numeric|min:0',
            'voucher' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ], [
            'operation_number.unique' => 'Este número de operación ya ha sido registrado anteriormente.',
            'voucher.mimes' => 'El archivo debe ser una imagen (JPG, PNG) o un documento PDF.',
            'voucher.max' => 'El archivo no debe pesar más de 2MB.'
        ]);

        // SUBIDA DE ARCHIVO
        $path = null;
        if ($request->hasFile('voucher')) {
            // Se guarda en storage/app/public/vouchers
            $path = $request->file('voucher')->store('vouchers', 'public');
        }

        // CREACIÓN DEL REGISTRO
        Payment::create([
            'person_id' => $person->id,
            'concept' => 'Matrícula', // Por ahora quemado, luego puede ser dinámico
            'amount' => $request->amount,
            'operation_number' => $request->operation_number,
            'voucher_image_path' => $path,
            'status' => 'pending', // Siempre nace en pendiente
        ]);

        return redirect()->back()->with('success', 'Tu voucher ha sido subido. Tesorería lo revisará pronto.');
    }
}
