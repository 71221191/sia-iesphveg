<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;
use App\Models\AcademicPeriod;
use App\Models\SocioeconomicFile;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; // ¡Añadir esta línea!

class CheckSocioeconomicStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('[CheckSocioeconomicStatus] -- INICIO del Middleware para ruta: ' . $request->fullUrl());

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Solo aplicar si el usuario está autenticado y tiene el rol de estudiante.
        if (!Auth::check()) {
            Log::info('[CheckSocioeconomicStatus] Usuario no autenticado. Pasando.');
            return $next($request);
        }

        if (!$user->hasRole('estudiante')) {
            Log::info('[CheckSocioeconomicStatus] Usuario ' . $user->name . ' no es estudiante. Pasando.');
            return $next($request);
        }

        Log::info('[CheckSocioeconomicStatus] Usuario autenticado y es estudiante: ' . $user->name);

        // 2. Obtener la persona asociada al usuario.
        $person = Person::where('user_id', $user->id)->first();
        if (!$person) {
            Log::warning('[CheckSocioeconomicStatus] Usuario estudiante ' . $user->name . ' SIN datos de Person asociados. Pasando (debería tenerlo).');
            return $next($request);
        }
        Log::info('[CheckSocioeconomicStatus] Persona asociada encontrada para ' . $user->name . '. ID Persona: ' . $person->id);


        // 3. Encontrar el período académico actual que está "abierto".
        $currentPeriod = AcademicPeriod::where('status', 'open')->first();
        if (!$currentPeriod) {
            Log::warning('[CheckSocioeconomicStatus] NO hay período académico OPEN. Pasando.');
            return $next($request);
        }
        Log::info('[CheckSocioeconomicStatus] Período académico OPEN encontrado: ' . $currentPeriod->name . ' (ID: ' . $currentPeriod->id . ')');


        // 4. Buscar la ficha socioeconómica de la persona para el PERÍODO ACADÉMICO ACTUAL.
        $socioeconomicFile = SocioeconomicFile::where('person_id', $person->id)
                                                ->where('academic_period_id', $currentPeriod->id)
                                                ->first();

        // 5. Verificar si la ficha existe Y está validada para el período actual.
        $isFichaValidated = $socioeconomicFile && $socioeconomicFile->is_validated;
        Log::info('[CheckSocioeconomicStatus] Ficha para periodo actual (ID ' . ($socioeconomicFile ? $socioeconomicFile->id : 'N/A') . ') validada: ' . ($isFichaValidated ? 'SI' : 'NO'));


        // Si NO existe O NO está validada...
        if (!$isFichaValidated) {
            // ... y si la ruta actual NO es una de las rutas de la ficha socioeconómica,
            // entonces redirigimos a la página para completarla.
            if (!$request->routeIs('socioeconomic.*')) {
                Log::warning('[CheckSocioeconomicStatus] Ficha NO validada y ruta NO es socioeconomic.*. Redirigiendo a socioeconomic.create.');
                return redirect()->route('socioeconomic.create')
                    ->with('warning', 'Por favor, complete o actualice su ficha socioeconómica para el periodo ' . $currentPeriod->name . ' y poder continuar.');
            } else {
                Log::info('[CheckSocioeconomicStatus] Ficha NO validada, PERO la ruta actual ES socioeconomic.*. Permitiendo acceso a la ficha.');
            }
        } else {
            Log::info('[CheckSocioeconomicStatus] Ficha VALIDADA para el período actual. Permitiendo acceso a la ruta.');
        }

        // Si todo está bien, permitimos que la solicitud continúe.
        return $next($request);
    }
}
