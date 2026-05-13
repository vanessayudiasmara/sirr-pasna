<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\JenisBencana;
use App\Models\Alternatif;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index(Request $request)
    {
        $query = Alternatif::with('proyek');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_proyek', 'like', '%' . $request->search . '%')
                ->orWhere('lokasi', 'like', '%' . $request->search . '%')
                ->orWhere('jenis_bencana', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER JENIS BENCANA
        if ($request->jenis_bencana) {
            $query->where('jenis_bencana', $request->jenis_bencana);
        }

        // FILTER TAHUN
        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // FILTER STATUS (dari proyek)
        if ($request->status) {
            $query->whereHas('proyek', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $alternatifs = $query->latest()
            ->paginate(10)
            ->withQueryString();

        // DATA DROPDOWN
        $jenisBencanas = JenisBencana::pluck('nama_bencana');

        $tahunList = Alternatif::pluck('tanggal')
            ->map(fn($tgl) => date('Y', strtotime($tgl)))
            ->unique()
            ->sortDesc();

        $statusList = [
            'Dalam Tinjauan',
            'Dalam Proses',
            'Selesai',
            'Tertunda'
        ];

        return view('proyek.index', compact(
            'alternatifs',
            'jenisBencanas',
            'tahunList',
            'statusList'
        ));
    }

    public function show(Alternatif $alternatif)
    {
        $alternatif->load('proyek');

        return view('proyek.show', compact('alternatif'));
    }


    public function updateStatus(Request $request, Proyek $proyek)
    {
        $request->validate([
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $proyek->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'tanggal_update' => now(),
        ]);

        // SYNC KE ALTERNATIF
        if ($proyek->alternatif) {
            $proyek->alternatif->update([
                'status' => $request->status
            ]);
        }

       return redirect()->to(
        $request->from === 'prioritas'
                ? route('prioritas.index')
                : route('proyek.index')
            )->with('success', 'Status proyek berhasil diperbarui');
        }
}