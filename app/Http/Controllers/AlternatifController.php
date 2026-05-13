<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use Illuminate\Http\Request;
use App\Models\JenisBencana;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Satuan;
use App\Models\Proyek; 
use App\Models\MasterProyek;

class AlternatifController extends Controller
{
    public function index(Request $request)
    {
        $query = Alternatif::query();

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_proyek', 'like', '%' . $request->search . '%')
                ->orWhere('jenis_bencana', 'like', '%' . $request->search . '%')
                ->orWhere('lokasi', 'like', '%' . $request->search . '%');
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

        // FILTER NAMA PROYEK
        if ($request->nama_proyek) {
            $query->where('nama_proyek', $request->nama_proyek);
        }

        // FILTER KEWENANGAN
        if ($request->kewenangan_aset) {
            $query->where('kewenangan_aset', $request->kewenangan_aset);
        }

        // FILTER STATUS (relasi proyek)
        if ($request->status) {
            $query->whereHas('proyek', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $alternatifs = $query->latest()->paginate(10)->withQueryString();

        // DATA FILTER
        $jenisBencanas = JenisBencana::all();
        $proyeks = MasterProyek::all();

        $tahunList = Alternatif::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->pluck('tahun');

        $kewenanganList = Alternatif::select('kewenangan_aset')
            ->distinct()
            ->pluck('kewenangan_aset');

        $statusList = Proyek::select('status')
            ->distinct()
            ->pluck('status');

        return view('alternatif.index', compact(
            'alternatifs',
            'jenisBencanas',
            'proyeks',
            'tahunList',
            'kewenanganList',
            'statusList'
        ));
    }

    public function create()
    {
        $jenisBencanas = JenisBencana::orderBy('nama_bencana', 'asc')->get();
        $kecamatans    = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();
        $desas         = Desa::orderBy('nama_desa', 'asc')->get();
        $satuans       = Satuan::orderBy('nama_satuan', 'asc')->get();
        $proyeks       = MasterProyek::orderBy('nama_proyek', 'asc')->get();

        return view('alternatif.create', compact(
            'jenisBencanas',
            'kecamatans',
            'desas',
            'satuans',
            'proyeks' 
        ));
    }

    // ================================
    // STORE
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_bencana' => 'required',
            'nama_proyek' => 'required',
            'jenis_infrastruktur' => 'required',
            'volume_kerusakan' => 'required|numeric',
            'korban_terdampak' => 'nullable|numeric',
            'dokumentasi.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $estimasiMasyarakat = $request->estimasi_masyarakat
            ? (int) str_replace('.', '', $request->estimasi_masyarakat)
            : null;

        $estimasiPemerintah = $request->estimasi_pemerintah
            ? (int) str_replace('.', '', $request->estimasi_pemerintah)
            : null;

        $estimasiBiaya = ($estimasiMasyarakat ?? 0) + ($estimasiPemerintah ?? 0);
        if ($estimasiBiaya == 0) {
            $estimasiBiaya = null;
        }

        $alternatif = Alternatif::create([
            'tanggal' => $request->tanggal,
            'jenis_bencana' => $request->jenis_bencana,
            'nama_proyek' => $request->nama_proyek,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'lokasi' => $request->kecamatan . ' - ' . $request->desa,
            'jenis_infrastruktur' => $request->jenis_infrastruktur,
            'volume_kerusakan' => $request->volume_kerusakan,
            'satuan_volume' => $request->satuan_volume,
            'estimasi_masyarakat' => $estimasiMasyarakat,
            'estimasi_pemerintah' => $estimasiPemerintah,
            'estimasi_biaya' => $estimasiBiaya,
            'kewenangan_aset' => $request->kewenangan_aset,
            'korban_terdampak' => $request->korban_terdampak,
            'keterangan' => $request->keterangan,
            'status' => 'Dalam Tinjauan',
        ]);

        // 🔥 SIMPAN KE TABEL PROYEK (TETAP AMAN)
        $alternatif->proyek()->create([
            'tanggal_kejadian' => $alternatif->tanggal,
            'jenis_bencana'    => $alternatif->jenis_bencana,
            'nama_proyek'      => $alternatif->nama_proyek,
            'lokasi'           => $alternatif->lokasi,
            'kecamatan'        => $alternatif->kecamatan,
            'desa'             => $alternatif->desa,
            'status'           => 'Dalam Tinjauan',
        ]);

        // UPLOAD FILE
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');

                $alternatif->dokumentasis()->create([
                    'file_path' => $path
                ]);
            }
        }

        $this->simpanNilaiAlternatif($alternatif);

        app(\App\Services\ArasService::class)->hitung();

        return redirect()
            ->route('alternatif.index')
            ->with('success', 'Data kerusakan berhasil disimpan');
    }

    // ================================
    // EDIT
    // ================================
    public function edit(Alternatif $alternatif)
    {
        $jenisBencanas = JenisBencana::orderBy('nama_bencana', 'asc')->get();
        $kecamatans    = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();
        $desas         = Desa::orderBy('nama_desa', 'asc')->get();
        $satuans       = Satuan::orderBy('nama_satuan', 'asc')->get();
        $proyeks       = MasterProyek::orderBy('nama_proyek', 'asc')->get();

        return view('alternatif.edit', compact(
            'alternatif',
            'jenisBencanas',
            'kecamatans',
            'desas',
            'satuans',
            'proyeks'
        ));
    }

    public function show(Alternatif $alternatif)
    {
        $jenisBencanas = JenisBencana::orderBy('nama_bencana', 'asc')->get();
        $kecamatans    = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();
        $desas         = Desa::orderBy('nama_desa', 'asc')->get();
        $satuans       = Satuan::orderBy('nama_satuan', 'asc')->get();
        $proyeks       = MasterProyek::orderBy('nama_proyek', 'asc')->get();

        return view('alternatif.show', compact(
            'alternatif',
            'jenisBencanas',
            'kecamatans',
            'desas',
            'satuans',
            'proyeks'
        ));
    }

    // ================================
    // UPDATE
    // ================================
    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_bencana' => 'required',
            'nama_proyek' => 'required',
            'jenis_infrastruktur' => 'required',
            'volume_kerusakan' => 'required|numeric',
            'dokumentasi.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $estimasiMasyarakat = $request->estimasi_masyarakat
            ? (int) str_replace('.', '', $request->estimasi_masyarakat)
            : null;

        $estimasiPemerintah = $request->estimasi_pemerintah
            ? (int) str_replace('.', '', $request->estimasi_pemerintah)
            : null;

        $estimasiBiaya = ($estimasiMasyarakat ?? 0) + ($estimasiPemerintah ?? 0);
        if ($estimasiBiaya == 0) {
            $estimasiBiaya = null;
        }

        $alternatif->update([
            'tanggal' => $request->tanggal,
            'jenis_bencana' => $request->jenis_bencana,
            'nama_proyek' => $request->nama_proyek,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'lokasi' => $request->kecamatan . ' - ' . $request->desa,
            'jenis_infrastruktur' => $request->jenis_infrastruktur,
            'volume_kerusakan' => $request->volume_kerusakan,
            'satuan_volume' => $request->satuan_volume,
            'estimasi_masyarakat' => $estimasiMasyarakat,
            'estimasi_pemerintah' => $estimasiPemerintah,
            'estimasi_biaya' => $estimasiBiaya,
            'kewenangan_aset' => $request->kewenangan_aset,
            'korban_terdampak' => $request->korban_terdampak,
            'keterangan' => $request->keterangan,
        ]);

        // UPLOAD FILE
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');

                $alternatif->dokumentasis()->create([
                    'file_path' => $path
                ]);
            }
        }

        // RESET NILAI
        NilaiAlternatif::where('alternatif_id', $alternatif->id)->delete();

        $this->simpanNilaiAlternatif($alternatif);

        app(\App\Services\ArasService::class)->hitung();

        return redirect()
            ->route('alternatif.index')
            ->with('success', 'Data kerusakan berhasil diperbarui');
    }

    // ================================
    // DELETE
    // ================================
    public function destroy(Alternatif $alternatif)
    {
        NilaiAlternatif::where('alternatif_id', $alternatif->id)->delete();

        $alternatif->delete();

        app(\App\Services\ArasService::class)->hitung();

        return back()->with('success', 'Data berhasil dihapus');
    }

    // ================================
    // HITUNG SKOR
    // ================================
    private function simpanNilaiAlternatif($alternatif)
    {
        $kriterias = Kriteria::with('subKriterias')->get();

        foreach ($kriterias as $kriteria) {

            $nilai = $alternatif->{$kriteria->field_name} ?? null;
            $skor = 0;

            foreach ($kriteria->subKriterias as $sub) {

                // CEK SATUAN DULU
                if (
                    !empty($sub->satuan) &&
                    strtolower(trim($sub->satuan)) != strtolower(trim($alternatif->satuan_volume))
                ) {
                    continue;
                }

                if (!is_null($sub->min_value) && !is_null($sub->max_value)) {

                    if ($nilai >= $sub->min_value && $nilai <= $sub->max_value) {
                        $skor = $sub->skor;
                        break;
                    }

                } elseif (!is_null($sub->min_value) && is_null($sub->max_value)) {

                    if ($nilai >= $sub->min_value) {
                        $skor = $sub->skor;
                        break;
                    }

                } elseif ($sub->nama == $nilai) {

                    $skor = $sub->skor;
                    break;
                }
            }

            if ($skor == 0) {
                $skor = 1;
            }

            NilaiAlternatif::create([
                'alternatif_id' => $alternatif->id,
                'kriteria_id'   => $kriteria->id,
                'skor'          => $skor
            ]);
        }
    }
}