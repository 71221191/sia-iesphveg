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
        Schema::table('course_sections', function (Blueprint $table) {
            // 1. Eliminamos la llave foránea vieja que apuntaba a 'users'
            // Nota: Laravel nombra las llaves como 'tabla_columna_foreign'
            $table->dropForeign(['teacher_id']);
        });

        Schema::table('course_sections', function (Blueprint $table) {
            // 2. Cambiamos la restricción para que apunte a 'people'
            $table->foreign('teacher_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_sections', function (Blueprint $table) {
            //
        });
    }
};
