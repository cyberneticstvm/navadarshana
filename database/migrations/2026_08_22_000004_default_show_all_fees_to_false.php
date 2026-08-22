<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('show_all_fees')->default(false)->change();
        });

        DB::table('students')->update(['show_all_fees' => false]);
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('show_all_fees')->default(true)->change();
        });
    }
};
