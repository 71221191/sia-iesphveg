<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Verificamos si no existe antes de crearla para evitar errores
            if (!Schema::hasColumn('enrollments', 'approval_resolution')) {
                $table->string('approval_resolution')->nullable()->after('section_label');
            }
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('approval_resolution');
        });
    }
};
