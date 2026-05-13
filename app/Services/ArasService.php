<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\HasilAras;

class ArasService
{
public function hitung()
{
    $alternatifs = Alternatif::with('nilaiAlternatifs')->get();
    $kriterias   = Kriteria::all();

    $totalBobot = $kriterias->sum('bobot');

    if (round($totalBobot, 2) != 1) {
        return;
    }

    if ($alternatifs->isEmpty() || $kriterias->isEmpty()) {
        return;
    }

    // ======================
    // 1. MATRKS KEPUTUSAN X
    // ======================
    $X = [];

    foreach ($alternatifs as $alt) {
        foreach ($kriterias as $k) {

            $nilai = $alt->nilaiAlternatifs
                ->where('kriteria_id', $k->id)
                ->first()?->skor ?? 0;

            $X[$alt->id][$k->id] = $nilai;
        }
    }

    // ======================
    // 2. HITUNG X0 (OPTIMUM)
    // ======================
    $X0 = [];

    foreach ($kriterias as $k) {
        $values = collect($X)->pluck($k->id);
        $X0[$k->id] = $values->max(); // semua benefit
    }

    // GABUNG MATRIX
    $matrix = [0 => $X0] + $X;

    // ======================
    // 3. NORMALISASI
    // ======================
    $R = [];

    foreach ($kriterias as $k) {

        $sum = 0;
        foreach ($matrix as $row) {
            $sum += $row[$k->id];
        }

        foreach ($matrix as $i => $row) {
            $R[$i][$k->id] = $sum == 0 ? 0 : $row[$k->id] / $sum; // Nilai / total semua nilai dalam kolom
        }
    }

    // ======================
    // 4. BOBOT
    // ======================
    $D = [];

    foreach ($R as $i => $row) {
        foreach ($row as $kId => $val) {
            $bobot = $kriterias->firstWhere('id', $kId)->bobot;
            $D[$i][$kId] = $val * $bobot; // Normalisasi × bobot
        }
    }

    // ======================
    // 5. HITUNG S
    // ======================
    $S = [];

    foreach ($D as $i => $row) {
        $S[$i] = array_sum($row); // Jumlah semua nilai tiap alternatif
    }

    if (!isset($S[0]) || $S[0] == 0) {
        return;
    }

    // ======================
    // 6. HITUNG K
    // ======================
    $K = [];

    foreach ($S as $i => $si) {
        if ($i == 0) continue;
        $K[$i] = $si / $S[0]; // Nilai alternatif / nilai optimal
    }

    arsort($K); // Urutkan dari nilai terbesar ke kecil

    // ======================
    // 7. SIMPAN HASIL
    // ======================
        $rank = 1;

    foreach ($K as $altId => $nilai) {

        HasilAras::updateOrCreate(
            ['alternatif_id' => $altId],
            [
                'nilai_normalisasi' => $S[$altId] ?? null,
                'nilai_preferensi'  => $nilai,
                'ranking'           => $rank++
            ]
        );
    }
    }
}

