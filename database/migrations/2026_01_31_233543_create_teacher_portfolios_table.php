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
        Schema::create('teacher_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_section_id')->constrained('course_sections')->onDelete('cascade');
            
            // Tipo de documento: Sílabo, Sesión de Aprendizaje o Instrumento de Evaluación
            $table->enum('type', ['syllabus', 'session', 'instrument']);
            
            $table->string('name'); // Nombre legible del archivo
            $table->string('file_path'); // Ruta en el storage
            
            // Estados: Pendiente, Aprobado u Observado
            $table->enum('status', ['pending', 'approved', 'observed'])->default('pending');
            $table->text('feedback')->nullable(); // Para que el Jefe de Área explique por qué lo observó
            
            // Auditoría de Validación
            $table->foreignId('validated_by')->nullable()->constrained('people');
            $table->timestamp('validated_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_portfolios');
    }
};
