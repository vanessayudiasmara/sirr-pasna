<?php

namespace App\Http\Controllers;

use App\Models\HasilAras;
use App\Models\Proyek;

class ArasController extends Controller
{
    public function daftar()
    {
        $query = HasilAras::with(['alternatif.proyek'])
        ->whereHas('alternatif.proyek', function($q){
            $q->where('status', '!=', 'Selesai');
        });

        // SEARCH
        if(request('search')){
            $query->whereHas('alternatif', function($q){
                $q->where('nama_proyek','like','%'.request('search').'%')
                ->orWhere('lokasi','like','%'.request('search').'%');
            });
        }

        // STATUS (AMBIL DARI PROYEK)
        if(request('status')){
            $query->whereHas('alternatif.proyek', function($q){
                $q->where('status', request('status'));
            });
        }

        // FILTER TAHUN 
        if(request('tahun')){
            $query->whereHas('alternatif', function($q){
                $q->whereYear('tanggal', request('tahun'));
            });
        }

        // PAGINATION (buat table)
        $data = $query
            ->orderBy('ranking')
            ->paginate(10)
            ->withQueryString();

        // FULL DATA (buat summary & filter)
        $allData = HasilAras::with(['alternatif.proyek'])->get();
        
        // LIST TAHUN
        $tahunList = $allData->pluck('alternatif.tanggal')
            ->map(fn($tgl) => date('Y', strtotime($tgl)))
            ->unique()
            ->sortDesc();

        // HITUNG STATUS (AMBIL DARI PROYEK)
        $selesai = Proyek::whereHas('alternatif')
            ->where('status','Selesai')
            ->count();

        $dalamTinjauan = Proyek::whereHas('alternatif')
            ->where('status','Dalam Tinjauan')
            ->count();

        $diproses = Proyek::whereHas('alternatif')
            ->where('status','Dalam Proses')
            ->count();

        $tertunda = Proyek::whereHas('alternatif')
            ->where('status','Tertunda')
            ->count();
            
        return view('prioritas.index', compact(
            'data',
            'selesai',
            'dalamTinjauan',
            'diproses',
            'tertunda',
            'tahunList'
        ));
    }
}