@extends('layouts.app')

@section('title','Data Kewenangan Aset')

@section('content')

<div class="p-6 space-y-6">

<div class="flex justify-between items-center">

<h2 class="text-xl font-semibold">
Data Kewenangan Aset
</h2>

<a href="{{ route('kewenangan-aset.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
Tambah Data
</a>

</div>


<div class="bg-white shadow rounded-lg overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-50 border-b">
<tr class="text-center text-gray-600">

<th class="py-3 w-16">No</th>
<th>Nama Kewenangan</th>
<th class="w-40">Aksi</th>

</tr>
</thead>

<tbody>

@forelse($data as $i => $item)

<tr class="border-b hover:bg-gray-50 text-center">

<td class="py-3">
{{ $i+1 }}
</td>

<td>
{{ $item->nama_kewenangan }}
</td>

<td class="flex justify-center gap-2 py-2">

<a href="{{ route('kewenangan-aset.edit',$item->id) }}"
class="px-3 py-1 bg-blue-500 text-white rounded text-sm">
Edit
</a>

<form action="{{ route('kewenangan-aset.destroy',$item->id) }}" method="POST">
@csrf
@method('DELETE')

<button class="px-3 py-1 bg-red-500 text-white rounded text-sm">
Hapus
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="3" class="py-6 text-center text-gray-400">
Data belum tersedia
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection