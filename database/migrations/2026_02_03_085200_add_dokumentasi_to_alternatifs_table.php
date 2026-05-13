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
        $table->string('dokumentasi')->nullable()->after('jenis_bencana');
    });
}

public function down()
{
    Schema::table('alternatifs', function (Blueprint $table) {
        $table->dropColumn('dokumentasi');
    });
}
};
