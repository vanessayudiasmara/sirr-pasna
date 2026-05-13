@extends('layouts.app')

@section('title', 'Detail Data Kerusakan')

@section('content')
<div class="-mt-4">

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">
        Detail Data Kerusakan dan Kerugian
    </h2>

    @include('alternatif._form', [
        'action' => '#',
        'method' => 'GET',
        'submitText' => null,
        'alternatif' => $alternatif,
        'readonly' => true
    ])

</div>
@endsection