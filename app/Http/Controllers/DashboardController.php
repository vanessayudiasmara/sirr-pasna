<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\HasilAras;
use App\Models\Proyek;

class DashboardController extends Controller
{
    public function index()
    {
        // Total data kerusakan
        $totalKerusakan = Alternatif::count();

        // Ambil hasil ARAS + relasi proyek
        $hasilAras = HasilAras::with('alternatif.proyek')
        ->whereHas('alternatif.proyek', function($q){
            $q->where('status', '!=', 'Selesai');
        })
        ->orderBy('ranking','asc')
        ->get();

        return view('dashboard', [
            'totalKerusakan' => $totalKerusakan,

            'totalPrioritas' => $hasilAras->count(),

            // hitung proyek selesai dari tabel proyek
            'proyekSelesai' => Proyek::where('status','Selesai')->count(),

            // tabel ranking prioritas
            'rankingProyek' => $hasilAras->take(6)
        ]);
    }
}