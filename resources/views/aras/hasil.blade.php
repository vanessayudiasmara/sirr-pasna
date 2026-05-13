@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Hasil Perhitungan ARAS</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Nama Proyek</th>
                <th>Nilai Preferensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil as $row)
            <tr>
                <td>{{ $row->ranking }}</td>
                <td>{{ $row->alternatif->nama_proyek }}</td>
                <td>{{ number_format($row->nilai_preferensi, 4) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
