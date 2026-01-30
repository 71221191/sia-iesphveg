<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'concept',
        'amount',
        'operation_number',
        'voucher_image_path',
        'status',
        'rejection_reason', // Asegúrate de que esté aquí también
        'verified_by',
        'verified_at'
    ];

    // --- AÑADE ESTA RELACIÓN ---
    public function person()
    {
        // Un pago pertenece a una persona
        return $this->belongsTo(Person::class, 'person_id');
    }

    // Opcional: Relación con el usuario que verificó el pago
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
