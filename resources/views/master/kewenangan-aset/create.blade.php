@extends('layouts.app')

@section('title','Tambah Kewenangan Aset')

@section('content')

<div class="space-y-6">

    <h2 class="text-xl font-semibold mb-6">
        Tambah Kewenangan Aset
    </h2>

<div class="bg-white shadow rounded-lg p-6">

<form method="POST" action="{{ route('kewenangan-aset.store') }}">
@csrf

<div>

<label>Nama Kewenangan</label>

<input type="text"
name="nama_kewenangan"
class="w-full border rounded px-3 py-2 mt-1"
placeholder="Contoh: Pemerintah Kabupaten Ponorogo">

</div>


<div class="flex justify-end mt-6 gap-2">

<a href="{{ route('kewenangan-aset.index') }}"
class="px-4 py-2 border rounded">
Batal
</a>

<button type="submit"
class="px-4 py-2 bg-gray-800 text-white rounded">
Simpan
</button>

</div>

</form>

</div>

</div>

@endsection