<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisKriteria;
use Illuminate\Validation\Rule;

class JenisKriteriaController extends Controller
{

    public function index()
    {
        $data = JenisKriteria::latest()->get();

        return view('master.jenis-kriteria.index', compact('data'));
    }


    public function create()
    {
        return view('master.jenis-kriteria.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_kriteria' => [
                'required',
                'unique:jenis_kriterias,nama_jenis_kriteria'
            ]
        ], [
            'nama_jenis_kriteria.required' => 'Nama jenis kriteria wajib diisi',
            'nama_jenis_kriteria.unique'   => 'Jenis kriteria sudah tersedia'
        ]);

        JenisKriteria::create([
            'nama_jenis_kriteria' => trim($request->nama_jenis_kriteria)
        ]);

        return redirect()->route('jenis-kriteria.index')
        ->with('success','Jenis kriteria berhasil ditambahkan');
    }


    public function edit(JenisKriteria $jenis_kriteria)
    {
        return view('master.jenis-kriteria.edit', compact('jenis_kriteria'));
    }


    public function update(Request $request, JenisKriteria $jenis_kriteria)
    {
        $request->validate([
            'nama_jenis_kriteria' => [
                'required',
                Rule::unique('jenis_kriterias', 'nama_jenis_kriteria')
                    ->ignore($jenis_kriteria->id)
            ]
        ], [
            'nama_jenis_kriteria.required' => 'Nama jenis kriteria wajib diisi',
            'nama_jenis_kriteria.unique'   => 'Jenis kriteria sudah tersedia'
        ]);

        $jenis_kriteria->update([
            'nama_jenis_kriteria' => trim($request->nama_jenis_kriteria)
        ]);

        return redirect()->route('jenis-kriteria.index')
        ->with('success','Jenis kriteria berhasil diperbarui');
    }


    public function destroy(JenisKriteria $jenis_kriteria)
    {
        $jenis_kriteria->delete();

        return redirect()->route('jenis-kriteria.index')
        ->with('success','Jenis kriteria berhasil dihapus');
    }

}