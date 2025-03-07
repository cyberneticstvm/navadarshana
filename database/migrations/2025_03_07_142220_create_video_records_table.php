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
        Schema::create('video_records', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('syllabus_id');
            $table->string('thumbnail')->nullable();
            $table->string('url')->nullable();
            $table->enum('source', ['youtube', 'vimeo', 'zoom', 'other'])->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('syllabus_id')->references('id')->on('syllabi')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_records');
    }
};
