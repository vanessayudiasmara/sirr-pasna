@extends('layouts.app')

@section('title','Edit Jenis Infrastruktur')

@section('content')

<div class="space-y-6">

    <h2 class="text-xl font-semibold mb-6">
        Edit Jenis Infrastruktur
    </h2>

<div class="bg-white shadow rounded-lg p-6">

<form method="POST" action="{{ route('jenis-infrastruktur.update',$jenis_infrastruktur->id) }}">
@csrf
@method('PUT')

<div>

<label>Nama Jenis Infrastruktur</label>

<input type="text"
name="nama_infrastruktur"
value="{{ $jenis_infrastruktur->nama_infrastruktur }}"
class="w-full border rounded px-3 py-2 mt-1">

</div>


<div class="flex justify-end mt-6 gap-2">

<a href="{{ route('jenis-infrastruktur.index') }}"
class="px-4 py-2 border rounded">
Batal
</a>

<button type="submit"
class="px-4 py-2 bg-gray-800 text-white rounded">
Update
</button>

</div>

</form>

</div>

</div>

@endsection