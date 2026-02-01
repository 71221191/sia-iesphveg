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
        Schema::create('practice_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_assignment_id')->constrained('practice_assignments')->onDelete('cascade');
            
            // Las dos notas (vigesimales o puntajes según el instituto)
            $table->decimal('institute_score', 5, 2)->nullable(); // Nota del supervisor IESP
            $table->decimal('school_score', 5, 2)->nullable();    // Nota del profesor del colegio
            
            $table->decimal('final_score', 5, 2)->nullable(); // El promedio de ambas
            $table->text('observations')->nullable();
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_evaluations');
    }
};
