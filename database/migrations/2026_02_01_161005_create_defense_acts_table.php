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
        Schema::create('defense_acts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thesis_project_id')->constrained('thesis_projects')->onDelete('cascade');
            $table->date('defense_date');
            $table->time('defense_time');
            $table->enum('modality', ['presencial', 'virtual'])->default('presencial');
            $table->decimal('score', 5, 2)->nullable();
            $table->enum('result', ['aprobado', 'desaprobado', 'pendiente'])->default('pendiente');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defense_acts');
    }
};
