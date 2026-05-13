<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KewenanganAset;

class KewenanganAsetController extends Controller
{

    public function index()
    {
        $data = KewenanganAset::latest()->get();

        return view('master.kewenangan-aset.index', compact('data'));
    }


    public function create()
    {
        return view('master.kewenangan-aset.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kewenangan' => 'required'
        ]);

        KewenanganAset::create([
            'nama_kewenangan' => $request->nama_kewenangan
        ]);

        return redirect()->route('kewenangan-aset.index')
        ->with('success','Kewenangan aset berhasil ditambahkan');
    }


    public function edit(KewenanganAset $kewenangan_aset)
    {
        return view('master.kewenangan-aset.edit', compact('kewenangan_aset'));
    }


    public function update(Request $request, KewenanganAset $kewenangan_aset)
    {
        $request->validate([
            'nama_kewenangan' => 'required'
        ]);

        $kewenangan_aset->update([
            'nama_kewenangan' => $request->nama_kewenangan
        ]);

        return redirect()->route('kewenangan-aset.index')
        ->with('success','Kewenangan aset berhasil diperbarui');
    }


    public function destroy(KewenanganAset $kewenangan_aset)
    {
        $kewenangan_aset->delete();

        return redirect()->route('kewenangan-aset.index')
        ->with('success','Kewenangan aset berhasil dihapus');
    }

}