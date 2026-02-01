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
        Schema::create('thesis_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thesis_project_id')->constrained('thesis_projects')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('people')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thesis_authors');
    }
};
