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
    Schema::table('alternatifs', function (Blueprint $table) {
        if (!Schema::hasColumn('alternatifs', 'tanggal_update')) {
            $table->date('tanggal_update')->nullable()->after('tanggal');
        }
    });
}

public function down()
{
    Schema::table('alternatifs', function (Blueprint $table) {
        $table->dropColumn('tanggal_update');
    });
}
};