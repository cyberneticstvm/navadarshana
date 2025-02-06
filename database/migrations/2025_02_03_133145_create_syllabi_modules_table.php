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
        Schema::create('syllabi_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('syllabus_id');
            $table->unsignedBigInteger('module_id');
            $table->foreign('syllabus_id')->references('id')->on('syllabi')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->unique(['syllabus_id', 'module_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabi_modules');
    }
};
