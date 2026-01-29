<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('identity_document_type_id')->constrained();
            $table->string('dni', 15)->unique();
            $table->string('names');
            $table->string('last_name_p');
            $table->string('last_name_m');
            $table->enum('gender', ['M', 'F']);
            $table->date('birth_date');
            $table->string('nationality')->default('PERUANA');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Relaciones con IDs (LA FORMA CORRECTA)
            $table->foreignId('ubigeo_birth_id')->nullable()->constrained('ubigeos');
            $table->foreignId('ubigeo_residence_id')->nullable()->constrained('ubigeos');
            $table->foreignId('marital_status_id')->nullable()->constrained();
            $table->foreignId('native_language_id')->nullable()->constrained('languages');
            $table->foreignId('ethnicity_id')->nullable()->constrained('ethnicities');
            $table->boolean('has_disability')->default(false);
            $table->foreignId('disability_type_id')->nullable()->constrained(); // Aquí usamos el ID, borramos el texto

            $table->string('conadis_number')->nullable();
            $table->string('minedu_code')->nullable();

            // --- CAMPOS QUE TRAJIMOS DEL ARCHIVO 2 (Fusionados aquí) ---

            // Trabajo y Estudios
            $table->boolean('has_work')->default(false);
            $table->string('work_type')->nullable();
            $table->boolean('has_previous_studies')->default(false);
            $table->text('previous_studies_at')->nullable();

            // Licencias y Becas
            $table->boolean('has_license')->default(false);
            $table->string('license_resolution')->nullable();
            $table->boolean('is_rebred_beneficiary')->default(false);
            $table->string('rebred_resolution')->nullable();
            $table->string('scholarship_modality')->nullable();
            $table->string('scholarship_resolution')->nullable();

            // Investigación
            $table->boolean('has_approved_project')->default(false);
            $table->text('project_name')->nullable();

            // Columna Virtual (Siempre al final)
            $table->string('full_name')->virtualAs("CONCAT(last_name_p, ' ', last_name_m, ', ', names)");

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
