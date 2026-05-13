<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisInfrastruktur;

class JenisInfrastrukturController extends Controller
{

    public function index()
    {
        $data = JenisInfrastruktur::latest()->get();

        return view('master.jenis-infrastruktur.index', compact('data'));
    }


    public function create()
    {
        return view('master.jenis-infrastruktur.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_infrastruktur' => 'required'
        ]);

        JenisInfrastruktur::create([
            'nama_infrastruktur' => $request->nama_infrastruktur
        ]);

        return redirect()->route('jenis-infrastruktur.index')
            ->with('success','Jenis Infrastruktur berhasil ditambahkan');
    }


    public function edit(JenisInfrastruktur $jenis_infrastruktur)
    {
        return view('master.jenis-infrastruktur.edit', compact('jenis_infrastruktur'));
    }


    public function update(Request $request, JenisInfrastruktur $jenis_infrastruktur)
    {
        $request->validate([
            'nama_infrastruktur' => 'required'
        ]);

        $jenis_infrastruktur->update([
            'nama_infrastruktur' => $request->nama_infrastruktur
        ]);

        return redirect()->route('jenis-infrastruktur.index')
            ->with('success','Jenis Infrastruktur berhasil diperbarui');
    }


    public function destroy(JenisInfrastruktur $jenis_infrastruktur)
    {
        $jenis_infrastruktur->delete();

        return redirect()->route('jenis-infrastruktur.index')
            ->with('success','Jenis Infrastruktur berhasil dihapus');
    }

}