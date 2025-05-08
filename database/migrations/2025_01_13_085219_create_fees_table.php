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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('branch_id');
            $table->decimal('amount', 7, 2)->default(0);
            $table->decimal('discount', 7, 2)->nullable()->default(0);
            $table->enum('category', ['admission', 'monthly', 'other']);
            $table->enum('type', ['advance', 'balance', 'full']);
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->unsignedBigInteger('payment_mode');
            $table->text('remarks')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->foreign('payment_mode')->references('id')->on('payment_modes')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
            //$table->unique(array('student_id', 'batch_id', 'category', 'month', 'year'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
