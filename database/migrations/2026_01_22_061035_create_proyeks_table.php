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
 Schema::create('proyeks', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal_kejadian');
        $table->string('jenis_bencana');
        $table->string('nama_proyek');
       
        $table->string('lokasi')->nullable(); // kecamatan - desa
        $table->string('kecamatan')->nullable();
        $table->string('desa')->nullable();
        
        $table->string('penanggung_jawab')->nullable();
        $table->date('tanggal_update')->nullable();
        $table->enum('status', [
            'Dalam Tinjauan',
            'Dalam Proses',
            'Selesai'
        ])->default('Dalam Tinjauan');
        $table->timestamps();

    // Relasi dengan Data Kerusakan
    $table->foreignId('alternatif_id')
      ->nullable()
      ->constrained()
      ->nullOnDelete();
});

}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};
