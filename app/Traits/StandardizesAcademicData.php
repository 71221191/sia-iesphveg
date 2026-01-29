<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait StandardizesAcademicData
{
    /**
     * Limpia y unifica nombres de Programas (Carreras)
     * Ej: "EDUCACIÓN SECUNDARIA, ESPECIALIDAD: MATEMÁTICA" -> "EDUCACIÓN SECUNDARIA ESPECIALIDAD MATEMÁTICA"
     */
    public function normalizarNombrePrograma($texto)
    {
        if (empty($texto)) return 'SIN PROGRAMA';

        // 1. A mayúsculas y quitar espacios extremos
        $texto = mb_strtoupper(trim($texto), 'UTF-8');

        // 2. Quitar dos puntos y comas (causantes de duplicados)
        $texto = str_replace([':', ';'], '', $texto);

        // 3. Convertir múltiples espacios o tabs en uno solo
        $texto = preg_replace('/\s+/', ' ', $texto);

        return trim($texto);
    }

    /**
     * Separa el Programa de la Resolución y limpia la RVM
     */
    public function extraerInfoPrograma($textoCompleto)
    {
        $info = [
            'programa' => $this->normalizarNombrePrograma($textoCompleto),
            'resolucion' => 'PLAN ANTIGUO'
        ];

        // Si el texto tiene paréntesis (Ej: EDUCACIÓN INICIAL (RVM 163-2019-MINEDU))
        if (preg_match('/\((.*?)\)/', $textoCompleto, $matches)) {
            // El programa es lo que está antes del paréntesis
            $nombreLimpio = trim(explode('(', $textoCompleto)[0]);
            $info['programa'] = $this->normalizarNombrePrograma($nombreLimpio);

            // La resolución es lo que está adentro del paréntesis, pero limpia
            $resRaw = mb_strtoupper($matches[1], 'UTF-8');
            $buscar = ['RESOLUCIÓN VICEMINISTERIAL', 'RESOLUCION VICEMINISTERIAL', 'Nº', 'N°', 'MINEDU'];
            $reemplazar = ['RVM', 'RVM', '', '', 'MINEDU'];

            $info['resolucion'] = trim(str_replace($buscar, $reemplazar, $resRaw));
        }

        return $info;
    }

    public function convertirSiNo($texto)
    {
        $texto = strtoupper(trim($texto));
        return ($texto === 'SÍ' || $texto === 'SI' || $texto === 'SIT' || $texto === 'VERDADERO');
    }

    public function extraerPeriodo($texto)
    {
        // Busca patrones como 2025-I o 2025-II
        if (preg_match('/20\d{2}-(?:I|II|1|2)/i', $texto, $matches)) {
            return strtoupper($matches[0]);
        }
        return '2025-I'; // Valor por defecto
    }
}
