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
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('short_name')->nullable();
            $table->timestamps();
        });

        Schema::create('study_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_program_id')->constrained();
            $table->string('name'); // Ej: 2019-II
            $table->string('resolution_code'); // RVM...
            $table->enum('evaluation_type', ['vigesimal', 'competency']);
            $table->boolean('is_active')->default(true);
            $table->year('valid_from_year');
            $table->year('valid_to_year')->nullable();
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_plan_id')->constrained();
            $table->string('code')->index();
            $table->string('name');
            $table->string('cycle', 5); // I, II...
            $table->decimal('credits', 4, 1);
            $table->integer('hours_theory')->default(0);
            $table->integer('hours_practice')->default(0);
            $table->enum('type', ['general', 'specific', 'elective']);
            $table->boolean('is_legacy')->default(false);
            $table->timestamps();
        });

        // Tabla de Competencias (C1, C2...)
        Schema::create('competencies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index(); // C1, C2
            $table->text('description');
            $table->string('domain')->nullable();
            $table->timestamps();
        });

        // Relación Curso -> Competencias
        Schema::create('course_competency', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('competency_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_config_tables');
    }
};
