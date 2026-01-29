<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitimos que cualquiera logueado pase (el middleware hará el resto)
    }

    public function rules(): array
    {
        return [
            // El alumno debe enviar un array de IDs de las secciones (Ej: [10, 45, 67])
            'sections' => 'required|array|min:1',
            'sections.*' => 'exists:course_sections,id',

            // Opcional: Validar que sea del turno correcto si tu lógica lo exige
            // 'shift_id' => 'required|exists:shifts,id',
        ];
    }

    public function messages()
    {
        return [
            'sections.required' => 'Debes seleccionar al menos un curso.',
            'sections.min' => 'Selecciona cursos para procesar tu matrícula.',
            'sections.*.exists' => 'Una de las secciones seleccionadas ya no está disponible.'
        ];
    }
}
