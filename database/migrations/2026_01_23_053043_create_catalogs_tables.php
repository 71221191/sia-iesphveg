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
        Schema::create('identity_document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // DNI, Carnet Extranjería
            $table->string('short_name', 5);
            $table->boolean('is_active')->default(true);
        });

        Schema::create('ubigeos', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique(); // Código INEI
            $table->string('department');
            $table->string('province');
            $table->string('district');
        });

        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Castellano, Quechua...
        });

        Schema::create('ethnicities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Mestizo, Afroperuano...
        });

        Schema::create('disability_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('enrollment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Regular, Subsanación...
        });

        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Mañana, Tarde, Noche
        });

        Schema::create('scholarship_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Beca 18, Ninguna...
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogs_tables');
    }
};
