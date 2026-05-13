@extends('layouts.app')

@section('title', 'Kriteria & Bobot')

@section('content')
<div class="space-y-6">

    <h2 class="text-xl font-semibold mb-6">
        Tambah Data Kriteria dan Bobot
    </h2>

    @include('kriteria._form', [
        'action' => route('kriteria.store'),
        'method' => 'POST',
        'submitText' => 'Simpan',
        'kriteria' => null
    ])
</div>
@endsection