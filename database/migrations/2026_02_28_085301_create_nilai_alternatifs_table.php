<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_alternatifs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('alternatif_id');
            $table->unsignedBigInteger('kriteria_id');

            $table->double('skor')->nullable();

            $table->timestamps();

            // Foreign key alternatif
            $table->foreign('alternatif_id')
                  ->references('id')
                  ->on('alternatifs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Foreign key kriteria
            $table->foreign('kriteria_id')
                  ->references('id')
                  ->on('kriterias')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_alternatifs');
    }
};