<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use App\Models\HasilAras;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view('laporan.index', compact('months'));
    }

    public function preview(Request $request)
    {
        $query = HasilAras::with(['alternatif.proyek'])
            ->join('alternatifs', 'hasil_aras.alternatif_id', '=', 'alternatifs.id')
            ->select('hasil_aras.*');

        if ($request->bulan) {
            $query->whereMonth('alternatifs.tanggal', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('alternatifs.tanggal', $request->tahun);
        }

        $data = $query
            ->orderBy('alternatifs.tanggal', 'asc')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    public function export(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|numeric',
            'tahun' => 'required|numeric',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        if ($bulan) {
            $namaFile = "Laporan_Rehabilitasi_Rekonstruksi_" . $namaBulan[$bulan] . "_{$tahun}.xlsx";
        } else {
            $namaFile = "Laporan_Rehabilitasi_Rekonstruksi_Tahun_{$tahun}.xlsx";
        }

        return Excel::download(
            new LaporanExport($bulan, $tahun),
            $namaFile
        );
    }
}
