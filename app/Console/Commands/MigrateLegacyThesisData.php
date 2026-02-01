<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateLegacyThesisData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-legacy-thesis-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando migración de datos de tesis...');

        // 1. Obtener personas con proyecto registrado
        $peopleWithProjects = \App\Models\Person::where('has_approved_project', 1)
            ->whereNotNull('project_name')
            ->get();

        $countCreated = 0;
        $countLinked = 0;

        foreach ($peopleWithProjects as $person) {
            // Normalizamos el título para evitar duplicados por un espacio o una minúscula
            $cleanTitle = trim(mb_strtoupper($person->project_name));

            // 2. Buscamos o creamos el proyecto (Fusión de parejas automática)
            $project = \App\Models\ThesisProject::firstOrCreate(
                ['title' => $cleanTitle],
                [
                    'research_line' => 'Importado del Sistema Anterior',
                    'status' => 'approved', // Ya estaba aprobado en la tabla people
                    'is_imported' => true
                ]
            );

            if ($project->wasRecentlyCreated) {
                $countCreated++;
            }

            // 3. Vinculamos a la persona con el proyecto (si no está ya vinculado)
            // Usamos syncWithoutDetaching para no borrar si ya había alguien
            $project->authors()->syncWithoutDetaching([$person->id]);
            $countLinked++;
        }

        $this->info("¡Migración terminada!");
        $this->info("Tesis únicas creadas: $countCreated");
        $this->info("Vínculos de alumnos realizados: $countLinked");
    }
}
