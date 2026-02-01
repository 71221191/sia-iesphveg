<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('practice_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la Institución Educativa
            $table->string('modular_code')->unique(); // Código Modular del MINEDU
            $table->enum('level', ['inicial', 'primaria', 'secundaria']);
            $table->string('director_name')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('ubigeo_id')->constrained('ubigeos'); // Ubicación del colegio
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_centers');
    }
};
