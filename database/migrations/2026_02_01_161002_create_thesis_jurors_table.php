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
        Schema::create('thesis_jurors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thesis_project_id')->constrained('thesis_projects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('people')->onDelete('cascade');
            $table->enum('role', ['presidente', 'secretario', 'vocal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_jurors');
    }
};
