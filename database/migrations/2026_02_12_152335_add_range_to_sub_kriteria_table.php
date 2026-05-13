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
        Schema::table('sub_kriterias', function (Blueprint $table) {
            $table->decimal('min_value', 10, 2)->nullable();
            $table->decimal('max_value', 10, 2)->nullable();
            $table->string('satuan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sub_kriterias', function (Blueprint $table) {
            $table->dropColumn(['min_value', 'max_value', 'satuan']);
        });
    }
};
