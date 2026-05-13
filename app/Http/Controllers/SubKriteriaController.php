<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Services\ArasService;

class SubKriteriaController extends Controller
{
    // Tampilkan daftar subkriteria per kriteria
    public function index($kriteria_id)
    {
        $kriteria = Kriteria::with('subKriterias')->findOrFail($kriteria_id);

        return view('subkriteria.index', compact('kriteria'));
    }

    // Simpan subkriteria baru
    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama'        => 'required|string|max:255',
            'skor'        => 'required|numeric',
            'min_value'   => 'nullable|numeric',
            'max_value'   => 'nullable|numeric',
            'satuan'      => 'nullable|string|max:50'
        ]);

        SubKriteria::create([
            'kriteria_id' => $request->kriteria_id,
            'nama'        => $request->nama,
            'skor'        => $request->skor,
            'min_value'   => $request->min_value,
            'max_value'   => $request->max_value,
            'satuan'      => $request->satuan
        ]);

        app(ArasService::class)->hitung();
        return back()->with('success', 'Sub Kriteria berhasil ditambahkan');
    }

    // Update subkriteria
    public function update(Request $request, $id)
    {
        $sub = SubKriteria::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'skor' => 'required|numeric'
        ]);

        $sub->update([
            'nama'      => $request->nama,
            'skor'      => $request->skor,
            'min_value' => $request->min_value,
            'max_value' => $request->max_value,
            'satuan'    => $request->satuan
        ]);

        app(ArasService::class)->hitung();
        return back()->with('success', 'Sub Kriteria berhasil diperbarui');
    }

    // Hapus subkriteria
    public function destroy($id)
    {
        $sub = SubKriteria::findOrFail($id);
        $sub->delete();
        
        app(ArasService::class)->hitung();
        return back()->with('success', 'Sub Kriteria berhasil dihapus');
    }
}
