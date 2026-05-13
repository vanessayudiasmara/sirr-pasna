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
    Schema::create('kategori_kriterias', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kriteria_id')->constrained()->cascadeOnDelete();
    $table->string('nama_kategori')->nullable();
    $table->string('rentang')->nullable();
    $table->string('satuan')->nullable();
    $table->double('nilai')->nullable();
    $table->timestamps();
});
}

public function down()
{
    Schema::dropIfExists('kategori_kriterias');
}
};