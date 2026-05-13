<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Satuan;
use Illuminate\Validation\Rule;

class SatuanController extends Controller
{

    public function index()
    {
        $data = Satuan::latest()->get();

        return view('master.satuan.index', compact('data'));
    }


    public function create()
    {
        return view('master.satuan.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => [
                'required',
                'unique:satuans,nama_satuan'
            ],

            'simbol' => [
                'required',
                'unique:satuans,simbol'
            ]

        ], [
            'nama_satuan.required' => 'Nama satuan wajib diisi',
            'nama_satuan.unique'   => 'Nama satuan sudah tersedia',

            'simbol.required'      => 'Simbol wajib diisi',
            'simbol.unique'        => 'Simbol sudah tersedia'
        ]);

        Satuan::create([
            'nama_satuan' => trim($request->nama_satuan),
            'simbol' => trim($request->simbol)
        ]);

        return redirect()->route('satuan.index')
            ->with('success','Satuan berhasil ditambahkan');
    }


    public function edit(Satuan $satuan)
    {
        return view('master.satuan.edit', compact('satuan'));
    }


    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'nama_satuan' => [
                'required',
                Rule::unique('satuans', 'nama_satuan')
                    ->ignore($satuan->id)
            ],

            'simbol' => [
                'required',
                Rule::unique('satuans', 'simbol')
                    ->ignore($satuan->id)
            ]

        ], [
            'nama_satuan.required' => 'Nama satuan wajib diisi',
            'nama_satuan.unique'   => 'Nama satuan sudah tersedia',

            'simbol.required'      => 'Simbol wajib diisi',
            'simbol.unique'        => 'Simbol sudah tersedia'
        ]);

        $satuan->update([
            'nama_satuan' => trim($request->nama_satuan),
            'simbol' => trim($request->simbol)
        ]);

        return redirect()->route('satuan.index')
            ->with('success','Satuan berhasil diperbarui');
    }


    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return redirect()->route('satuan.index')
            ->with('success','Satuan berhasil dihapus');
    }

}