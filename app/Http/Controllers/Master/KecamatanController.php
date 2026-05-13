<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use Illuminate\Validation\Rule;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan','asc')
                    ->paginate(10);

        return view('master.kecamatan.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('master.kecamatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => [
                'required',
                'unique:kecamatans,nama_kecamatan'
            ]
        ], [
            'nama_kecamatan.required' => 'Nama kecamatan wajib diisi',
            'nama_kecamatan.unique'   => 'Nama kecamatan sudah tersedia'
        ]);

        Kecamatan::create([
            'nama_kecamatan' => $request->nama_kecamatan
        ]);

        return redirect()->route('kecamatan.index')
            ->with('success','Kecamatan berhasil ditambahkan');
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('master.kecamatan.edit', compact('kecamatan'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama_kecamatan' => [
                'required',
                Rule::unique('kecamatans', 'nama_kecamatan')
                    ->ignore($kecamatan->id)
            ]
        ], [
            'nama_kecamatan.required' => 'Nama kecamatan wajib diisi',
            'nama_kecamatan.unique'   => 'Nama kecamatan sudah tersedia'
        ]);

        $kecamatan->update([
            'nama_kecamatan' => $request->nama_kecamatan
        ]);

        return redirect()->route('kecamatan.index')
            ->with('success','Kecamatan berhasil diperbarui');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')
            ->with('success','Kecamatan berhasil dihapus');
    }
}