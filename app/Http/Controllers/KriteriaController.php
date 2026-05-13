<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\JenisKriteria;
use App\Models\Satuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ArasService;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::with('subKriterias')->paginate(10);
        return view('kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        $jenisKriterias = JenisKriteria::orderBy('nama_jenis_kriteria')->get();
        $satuans = Satuan::orderBy('nama_satuan')->get();

        return view('kriteria.create', compact(
            'jenisKriterias',
            'satuans'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required',
            'jenis'         => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:1',
        ]);

        // VALIDASI TOTAL BOBOT
        $totalBobot = Kriteria::sum('bobot') + $request->bobot;

        if ($totalBobot > 1) {
            return back()->withInput()->withErrors([
                'bobot' => 'Total bobot seluruh kriteria tidak boleh lebih dari 1 (100%).'
            ]);
        }

        $kriteria = Kriteria::create([
            'nama_kriteria' => $request->nama_kriteria,
            'field_name'    => Str::snake($request->nama_kriteria),
            'jenis'         => $request->jenis,
            'bobot'         => $request->bobot,
            'deskripsi'     => $request->deskripsi,
            'satuan'        => $request->satuan,
            'tipe_input'    => $request->tipe_input ?? 'select'
        ]);

        // SIMPAN SUB KRITERIA (jika ada)
        if ($request->kategori && isset($request->kategori['nama_kategori'])) {
            foreach ($request->kategori['nama_kategori'] as $i => $nama) {

                if (empty($nama) && empty($request->kategori['nilai'][$i])) {
                    continue;
                }

                SubKriteria::create([
                    'kriteria_id' => $kriteria->id,
                    'nama'        => $nama,
                    'skor'        => $request->kategori['nilai'][$i] ?? 0,
                    'min_value'   => $request->kategori['min_value'][$i] ?? null,
                    'max_value'   => $request->kategori['max_value'][$i] ?? null,
                    'satuan'      => $request->kategori['satuan'][$i] ?? null,
                ]);

            }
        }

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit(Kriteria $kriteria)
    {
        $jenisKriterias = JenisKriteria::orderBy('nama_jenis_kriteria')->get();
        $satuans = Satuan::orderBy('nama_satuan')->get();

        return view('kriteria.edit', compact(
            'kriteria',
            'jenisKriterias',
            'satuans'
        ));
    }

        public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama_kriteria' => 'required',
            'jenis'         => 'required|in:benefit,cost',
            'bobot'         => 'required|numeric|min:0|max:1',
        ]);

        $totalBobot = Kriteria::where('id', '!=', $kriteria->id)
                ->sum('bobot') + $request->bobot;

        if ($totalBobot > 1) {
            return back()->withInput()->withErrors([
                'bobot' => 'Total bobot seluruh kriteria tidak boleh lebih dari 1 (100%).'
            ]);
        }

        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'jenis'         => $request->jenis,
            'bobot'         => $request->bobot,
            'deskripsi'     => $request->deskripsi,
            'satuan'        => $request->satuan,
            'tipe_input'    => $request->tipe_input ?? 'select'
        ]);

        // Hapus sub lama
        $kriteria->subKriterias()->delete();

        // Simpan ulang
        if ($request->kategori && isset($request->kategori['nama_kategori'])) {

            foreach ($request->kategori['nama_kategori'] as $i => $nama) {

                if (empty($nama) && empty($request->kategori['nilai'][$i])) {
                    continue;
                }

                SubKriteria::create([
                    'kriteria_id' => $kriteria->id,
                    'nama'        => $nama,
                    'skor'        => $request->kategori['nilai'][$i] ?? 0,
                    'min_value'   => $request->kategori['min_value'][$i] ?? null,
                    'max_value'   => $request->kategori['max_value'][$i] ?? null,
                    'satuan'      => $request->kategori['satuan'][$i] ?? null,
                ]);
            }
        }

        // =========================
        // RE-HITUNG ARAS
        // =========================
        app(ArasService::class)->hitung();

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui!');
    }


    public function destroy(Kriteria $kriteria)
    {
        $kriteria->subKriterias()->delete();
        $kriteria->delete();

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus!');
    }
}
