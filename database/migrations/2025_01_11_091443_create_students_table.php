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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('email', 100)->unique();
            $table->string('mobile', 10);
            $table->string('alt_mobile', 10)->nullable();
            $table->date('dob')->nullable();
            $table->text('qualification')->nullable();
            $table->string('reservation_category')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('id_type')->default(0);
            $table->string('id_number', 100)->unique();
            $table->enum('enrollment_type', ['offline', 'online', 'other']);
            $table->enum('current_status', ['active', 'inactive', 'other']);
            $table->date('date_of_admission');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
