<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisBencana;
use Illuminate\Validation\Rule;

class JenisBencanaController extends Controller
{

    public function index()
    {
        $bencanas = JenisBencana::latest()->paginate(10);
        
        return view('master.bencana.index', compact('bencanas'));
    }


    public function create()
    {
        return view('master.bencana.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_bencana' => [
                'required',
                'unique:jenis_bencanas,nama_bencana'
            ]
        ], [
            'nama_bencana.required' => 'Jenis bencana wajib diisi',
            'nama_bencana.unique'   => 'Jenis bencana sudah tersedia'
        ]);

        JenisBencana::create([
            'nama_bencana' => $request->nama_bencana
        ]);

        return redirect()->route('jenis-bencana.index')
        ->with('success','Jenis bencana berhasil ditambahkan');
    }


    public function edit($id)
    {
        $bencana = JenisBencana::findOrFail($id);

        return view('master.bencana.edit', compact('bencana'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bencana' => [
                'required',
                Rule::unique('jenis_bencanas', 'nama_bencana')->ignore($id)
            ]
        ], [
            'nama_bencana.required' => 'Jenis bencana wajib diisi',
            'nama_bencana.unique'   => 'Jenis bencana sudah tersedia'
        ]);

        $bencana = JenisBencana::findOrFail($id);

        $bencana->update([
            'nama_bencana' => $request->nama_bencana
        ]);

        return redirect()->route('jenis-bencana.index')
        ->with('success','Jenis bencana berhasil diperbarui');
    }


    public function destroy(JenisBencana $jenis_bencana)
    {
        $jenis_bencana->delete();

        return redirect()->route('jenis-bencana.index')
            ->with('success','Jenis bencana berhasil dihapus');
    }

}