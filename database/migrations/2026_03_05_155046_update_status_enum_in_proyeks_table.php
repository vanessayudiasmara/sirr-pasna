<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE proyeks 
            MODIFY status ENUM(
                'Dalam Tinjauan',
                'Dalam Proses',
                'Selesai',
                'Tertunda'
            ) NOT NULL DEFAULT 'Dalam Tinjauan'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE proyeks 
            MODIFY status ENUM(
                'Dalam Tinjauan',
                'Dalam Proses',
                'Selesai'
            ) NOT NULL DEFAULT 'Dalam Tinjauan'
        ");
    }
};