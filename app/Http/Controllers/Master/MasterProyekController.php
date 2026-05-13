<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterProyek;
use Illuminate\Validation\Rule;

class MasterProyekController extends Controller
{
    public function index()
    {
        $proyeks = MasterProyek::latest()->paginate(10);

        return view('master.proyek.index', compact('proyeks'));
    }

    public function create()
    {
        return view('master.proyek.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => [
                'required',
                'unique:master_proyeks,nama_proyek'
            ]
        ], [
            'nama_proyek.required' => 'Nama proyek wajib diisi',
            'nama_proyek.unique'   => 'Nama proyek sudah tersedia'
        ]);

        MasterProyek::create([
            'nama_proyek' => $request->nama_proyek
        ]);

        return redirect()->route('master-proyek.index')
            ->with('success', 'Proyek berhasil ditambahkan');
    }

    public function edit(MasterProyek $master_proyek)
    {
        return view('master.proyek.edit', compact('master_proyek'));
    }

    public function update(Request $request, MasterProyek $master_proyek)
    {
        $request->validate([
            'nama_proyek' => [
                'required',
                Rule::unique('master_proyeks', 'nama_proyek')
                    ->ignore($master_proyek->id)
            ]
        ], [
            'nama_proyek.required' => 'Nama proyek wajib diisi',
            'nama_proyek.unique'   => 'Nama proyek sudah tersedia'
        ]);

        $master_proyek->update([
            'nama_proyek' => $request->nama_proyek
        ]);

        return redirect()->route('master-proyek.index')
            ->with('success', 'Proyek berhasil diupdate');
    }

    public function destroy(MasterProyek $master_proyek)
    {
        $master_proyek->delete();

        return back()->with('success', 'Proyek berhasil dihapus');
    }
}