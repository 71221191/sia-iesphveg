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
        // Grados y Títulos
        Schema::create('thesis_projects', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('research_line');
            $table->foreignId('advisor_id')->nullable()->constrained('users');
            $table->enum('status', ['registered', 'approved', 'defended']);
            $table->boolean('is_imported')->default(false);
            $table->timestamps();
        });

        // Auditoría (Para rastrear quién cambió notas)
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('action'); // UPDATE, DELETE, LOGIN
            $table->string('table_name');
            $table->unsignedBigInteger('record_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45);
            $table->timestamps();
        });

        // Historial de importaciones de Excel
        Schema::create('legacy_imports', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->integer('records_processed');
            $table->json('errors_log')->nullable();
            $table->foreignId('imported_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_modules_tables');
    }
};
