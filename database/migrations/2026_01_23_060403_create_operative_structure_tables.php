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
        Schema::create('academic_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: 2025-I
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['planning', 'open', 'closed'])->default('planning');
            $table->timestamps();
        });

        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('academic_period_id')->constrained();
            $table->string('name'); // A, B, Única
            $table->foreignId('teacher_id')->nullable()->constrained('users');
            $table->integer('vacancy_limit')->default(40);
            $table->boolean('is_closed')->default(false);
            $table->string('acta_number')->nullable();
            $table->timestamp('acta_close_date')->nullable();
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_section_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day_of_week'); // 1=Lunes, 7=Domingo
            $table->time('start_time');
            $table->time('end_time');
            $table->string('classroom')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operative_structure_tables');
    }
};
