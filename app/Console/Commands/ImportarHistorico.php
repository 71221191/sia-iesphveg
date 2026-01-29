<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\LegacyGradesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportarHistorico extends Command
{
    // El nombre que escribirás en la terminal
    protected $signature = 'importar:historico {archivo}';

    // La descripción
    protected $description = 'Importa el historial de notas masivo desde storage/app sin usar el navegador';

    public function handle()
    {
        $nombreArchivo = $this->argument('archivo');
        $ruta = storage_path('app/' . $nombreArchivo);

        if (!file_exists($ruta)) {
            $this->error("❌ El archivo no existe en: $ruta");
            return;
        }

        $this->info("🚀 Iniciando importación masiva de: $nombreArchivo");
        $this->info("⏳ Esto puede tardar unos minutos. Por favor espera...");

        $inicio = microtime(true);

        try {
            // Usamos el Importador que ya creaste.
            // Importante: Generamos un ID aleatorio para el cache
            $importId = uniqid();

            // Forzamos la ejecución SIN COLAS para ver el error en vivo si ocurre
            // (Si LegacyGradesImport tiene "ShouldQueue", Excel lo intentará poner en cola.
            // Para forzarlo ahora en pantalla, usamos import() normal pero quitamos ShouldQueue del archivo PHP
            // O, simplemente confiamos en el proceso).

            Excel::import(new LegacyGradesImport($importId), $ruta);

            $tiempo = round(microtime(true) - $inicio, 2);

            // Accedemos al reporte estático
            $res = LegacyGradesImport::$reporte;

            $this->newLine();
            $this->info("✅ ¡TERMINADO en $tiempo segundos!");
            $this->table(
                ['Métrica', 'Cantidad'],
                [
                    ['Creados', $res['creados']],
                    ['Actualizados', $res['actualizados']],
                    ['Omitidos', $res['omitidos']],
                ]
            );

            if (count($res['errores']) > 0) {
                $this->error("⚠️ Hubo " . count($res['errores']) . " errores.");
                if ($this->confirm('¿Quieres ver los errores en pantalla?')) {
                    foreach ($res['errores'] as $error) {
                        $this->line($error);
                    }
                }
            }

        } catch (\Exception $e) {
            $this->error("💀 ERROR FATAL: " . $e->getMessage());
            $this->error("Línea: " . $e->getLine());
            $this->error("Archivo: " . $e->getFile());
        }
    }
}
