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
        Schema::create('socioeconomic_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people'); // El alumno
            $table->foreignId('academic_period_id')->constrained();
            $table->boolean('has_children')->default(false);
            $table->integer('children_count')->default(0);
            $table->boolean('works')->default(false);
            $table->string('work_type')->nullable();
            $table->foreignId('scholarship_type_id')->constrained();
            $table->json('housing_data')->nullable(); // Para flexibilidad de campos
            $table->boolean('is_validated')->default(false);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people');
            $table->string('concept'); // Matrícula, Pensión, etc.
            $table->decimal('amount', 10, 2);
            $table->string('operation_number')->unique();
            $table->string('voucher_image_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('people');
            $table->foreignId('academic_period_id')->constrained();
            $table->foreignId('study_plan_id')->constrained();
            $table->string('cycle'); // El ciclo que cursa
            $table->foreignId('enrollment_type_id')->constrained();
            $table->foreignId('shift_id')->constrained();
            $table->char('section_label', 2); // A, B
            $table->boolean('library_debt')->default(false);
            $table->string('qr_hash')->nullable();
            $table->timestamps();
        });

        Schema::create('enrollment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained();
            $table->foreignId('course_section_id')->nullable()->constrained(); // Null si es convalidación
            $table->decimal('final_score_numeric', 5, 2)->nullable();
            $table->boolean('is_legacy')->default(false);
            $table->enum('status', ['enrolled', 'approved', 'failed', 'withdrawn', 'validated']);
            $table->integer('attempt_number')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_and_payments_tables');
    }
};
