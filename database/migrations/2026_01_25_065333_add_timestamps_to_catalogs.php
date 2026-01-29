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
        // Agregamos timestamps (created_at, updated_at) a todas las tablas de catálogo

        Schema::table('enrollment_types', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('shifts', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('scholarship_types', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('identity_document_types', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('marital_statuses', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('languages', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('ethnicities', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('disability_types', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si revertimos, borramos las columnas
        $tables = [
            'enrollment_types', 'shifts', 'scholarship_types',
            'identity_document_types', 'marital_statuses',
            'languages', 'ethnicities', 'disability_types'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }
};
