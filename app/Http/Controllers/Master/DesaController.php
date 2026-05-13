<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Validation\Rule;

class DesaController extends Controller
{

    public function index()
    {
        $desas = Desa::with('kecamatan')
            ->join('kecamatans', 'desas.kecamatan_id', '=', 'kecamatans.id')
            ->orderBy('kecamatans.nama_kecamatan', 'asc')
            ->orderBy('desas.nama_desa', 'asc')
            ->select('desas.*')
            ->paginate(10);

        return view('master.desa.index', compact('desas'));
    }


    public function create()
    {
        $kecamatans = Kecamatan::all();

        return view('master.desa.create', compact('kecamatans'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required',

            'nama_desa' => [
                'required',

                Rule::unique('desas')
                    ->where(function ($query) use ($request) {

                        return $query
                            ->where('kecamatan_id', $request->kecamatan_id)
                            ->whereRaw(
                                'LOWER(TRIM(nama_desa)) = ?',
                                [strtolower(trim($request->nama_desa))]
                            );
                    })
            ]

        ], [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih',
            'nama_desa.required'    => 'Nama desa wajib diisi',
            'nama_desa.unique'      => 'Desa pada kecamatan tersebut sudah tersedia'
        ]);

        Desa::create([
            'kecamatan_id' => $request->kecamatan_id,
            'nama_desa' => trim($request->nama_desa)
        ]);

        return redirect()->route('desa.index')
            ->with('success','Desa berhasil ditambahkan');
    }


    public function edit($id)
    {
        $desa = Desa::findOrFail($id);
        $kecamatans = Kecamatan::all();

        return view('master.desa.edit', compact('desa','kecamatans'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'kecamatan_id' => 'required',

            'nama_desa' => [
                'required',

                Rule::unique('desas')
                    ->where(function ($query) use ($request) {

                        return $query
                            ->where('kecamatan_id', $request->kecamatan_id)
                            ->whereRaw(
                                'LOWER(TRIM(nama_desa)) = ?',
                                [strtolower(trim($request->nama_desa))]
                            );
                    })
                    ->ignore($id)
            ]

        ], [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih',
            'nama_desa.required'    => 'Nama desa wajib diisi',
            'nama_desa.unique'      => 'Desa pada kecamatan tersebut sudah tersedia'
        ]);

        $desa = Desa::findOrFail($id);

        $desa->update([
            'kecamatan_id' => $request->kecamatan_id,
            'nama_desa' => trim($request->nama_desa)
        ]);

        return redirect()->route('desa.index')
            ->with('success','Desa berhasil diperbarui');
    }


    public function destroy($id)
    {
        $desa = Desa::findOrFail($id);

        $desa->delete();

        return redirect()->route('desa.index')
            ->with('success','Desa berhasil dihapus');
    }

}