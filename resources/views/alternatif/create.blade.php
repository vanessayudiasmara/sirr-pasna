@extends('layouts.app')

@section('title', 'Data Kerusakan')

@section('content')
<div class="space-y-6">

    <h2 class="text-xl font-semibold mb-6">
        Tambah Data Kerusakan dan Kerugian
    </h2>

    @include('alternatif._form', [
        'action' => route('alternatif.store'),
        'method' => 'POST',
        'submitText' => 'Simpan',
        'alternatif' => null
    ])

</div>
@endsection