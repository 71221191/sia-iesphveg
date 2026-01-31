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
        Schema::table('competencies', function (Blueprint $table) {
            // Quitamos el campo de texto viejo
            $table->dropColumn('domain');
            // Agregamos la relación oficial
            $table->foreignId('domain_id')->after('id')->constrained('domains');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competencies', function (Blueprint $table) {
            //
        });
    }
};
