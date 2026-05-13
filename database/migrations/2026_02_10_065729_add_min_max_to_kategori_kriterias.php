<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('kategori_kriterias', function (Blueprint $table) {
        $table->double('min_value')->nullable()->after('rentang');
        $table->double('max_value')->nullable()->after('min_value');
    });
}

public function down()
{
    Schema::table('kategori_kriterias', function (Blueprint $table) {
        $table->dropColumn(['min_value', 'max_value']);
    });
}
};
