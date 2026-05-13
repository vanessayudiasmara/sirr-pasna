@extends('layouts.app')

@section('title', 'Data Kerusakan')

@section('content')
<div class="space-y-6">

    <h2 class="text-xl font-semibold mb-6">
        Edit Data Kerusakan dan Kerugian
    </h2>

    @include('alternatif._form', [
        'action' => route('alternatif.update', $alternatif),
        'method' => 'PUT',
        'submitText' => 'Update',
        'alternatif' => $alternatif
    ])

</div>
@endsection