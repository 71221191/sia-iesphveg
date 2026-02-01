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
        Schema::create('practice_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_period_id')->constrained('academic_periods');
            $table->foreignId('student_id')->constrained('people'); // El Alumno
            $table->foreignId('practice_center_id')->constrained('practice_centers'); // El Colegio
            $table->foreignId('teacher_id')->constrained('people'); // El Docente Supervisor del IESP
            
            $table->string('classroom_teacher_name')->nullable(); // El profesor del colegio que recibe al alumno
            $table->string('grade_and_section')->nullable(); // En qué aula del colegio está practicando
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_assignments');
    }
};
