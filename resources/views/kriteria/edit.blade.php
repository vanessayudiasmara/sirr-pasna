@extends('layouts.app')

@section('title', 'Kriteria & Bobot')

@section('content')
<div class="space-y-6">

    <h2 class="text-xl font-semibold mb-6">
        Edit Data Kriteria dan Bobot
    </h2>

    @include('kriteria._form', [
        'action' => route('kriteria.update', $kriteria),
        'method' => 'PUT',
        'submitText' => 'Update',
        'kriteria' => $kriteria
    ])
</div>
@endsection