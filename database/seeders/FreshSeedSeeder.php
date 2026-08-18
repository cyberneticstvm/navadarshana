<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FreshSeedSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $tables = DB::select('SHOW TABLES');

        $databaseName = DB::getDatabaseName();
        $tableKey = "Tables_in_{$databaseName}";

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            // Keep migration history intact
            if ($tableName === 'migrations') {
                continue;
            }

            DB::table($tableName)->truncate();
        }

        Schema::enableForeignKeyConstraints();

        // Run your normal seeders
        $this->call(DatabaseSeeder::class);
    }
}