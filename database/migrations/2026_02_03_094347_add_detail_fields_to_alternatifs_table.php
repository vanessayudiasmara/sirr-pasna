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
        if (!Schema::hasColumn('alternatifs', 'kecamatan')) {
            $table->string('kecamatan')->nullable()->after('lokasi');
        }

        if (!Schema::hasColumn('alternatifs', 'desa')) {
            $table->string('desa')->nullable()->after('kecamatan');
        }

        if (!Schema::hasColumn('alternatifs', 'satuan_volume')) {
            $table->string('satuan_volume')->nullable()->after('volume_kerusakan');
        }

        if (!Schema::hasColumn('alternatifs', 'estimasi_masyarakat')) {
            $table->bigInteger('estimasi_masyarakat')->nullable();
        }

        if (!Schema::hasColumn('alternatifs', 'estimasi_pemerintah')) {
            $table->bigInteger('estimasi_pemerintah')->nullable();
        }

        if (!Schema::hasColumn('alternatifs', 'keterangan')) {
            $table->text('keterangan')->nullable();
        }
    });
    }};