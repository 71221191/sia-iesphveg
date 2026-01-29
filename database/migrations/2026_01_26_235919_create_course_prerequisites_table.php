<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_prerequisites', function (Blueprint $table) {
            $table->id();
            // El curso que TIENE el prerrequisito
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            // El curso que ES el prerrequisito (debe estar aprobado antes)
            $table->foreignId('prerequisite_course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamps();

            // Esto asegura que una combinación curso-prerrequisito sea única
            $table->unique(['course_id', 'prerequisite_course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_prerequisites');
    }
};
