<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alternatifs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis_bencana');
            $table->string('nama_proyek');
            $table->string('lokasi')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();

            $table->string('jenis_infrastruktur');
            $table->string('volume_kerusakan'); 
            $table->string('satuan_volume')->nullable();
            $table->string('kewenangan_aset')->nullable();
            
            $table->bigInteger('estimasi_biaya');
            $table->bigInteger('estimasi_masyarakat')->nullable();
            $table->bigInteger('estimasi_pemerintah')->nullable();
           
            $table->integer('korban_terdampak')->nullable();
            $table->string('status')->default('Dalam Tinjauan');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_update')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternatifs');
    }
};
