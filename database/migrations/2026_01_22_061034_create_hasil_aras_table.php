<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_aras', function (Blueprint $table) {
        $table->id();
        $table->foreignId('alternatif_id')->constrained()->onDelete('cascade');
        $table->float('nilai_normalisasi')->nullable();
        $table->float('nilai_preferensi')->nullable();
        $table->integer('ranking')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_aras');
    }
};
