@extends('layouts.app')

@section('title', 'Kriteria & Bobot')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Data Kriteria & Bobot
            </h2>
            <p class="text-gray-500 text-sm">
                Pengaturan parameter perhitungan metode ARAS
            </p>
        </div> 

        <a href="{{ route('kriteria.create') }}"
           class="bg-[color:var(--bpbd-blue)] text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
            + Tambah Kriteria
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="min-w-full text-sm table-fixed">

            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-center w-16">No</th>
                    <th class="px-4 py-3">Nama Kriteria</th>
                    <th class="px-4 py-3 text-center w-32">Jenis</th>
                    <th class="px-4 py-3 text-center w-24">Bobot</th>
                    <th class="px-4 py-3 w-40">Satuan</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-center w-36">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

            @forelse($kriterias as $index => $kriteria)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3 text-center">
                        {{ $kriterias->firstItem() + $index }}
                    </td>

                    <td class="px-4 py-3 font-medium">
                        {{ $kriteria->nama_kriteria }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($kriteria->jenis == 'benefit')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Benefit
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                Cost
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center font-semibold">
                        {{ $kriteria->bobot }}
                    </td>

                    <td class="px-4 py-3">
                        @php
                            $satuan = $kriteria->subKriterias
                                ->pluck('satuan')
                                ->filter()
                                ->unique()
                                ->implode(', ');
                        @endphp

                        {{ $satuan !== '' ? $satuan : '-' }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $kriteria->deskripsi ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">

                        {{-- EDIT --}}
                        <a href="{{ route('kriteria.edit', $kriteria->id) }}"
                        class="px-3 py-1 text-xs font-medium rounded-md 
                                bg-orange-600 text-white 
                                hover:bg-orange-700 transition">
                            Edit
                        </a>

                        {{-- HAPUS --}}
                        <form action="{{ route('kriteria.destroy', $kriteria->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Yakin hapus data ini?')"
                                    class="px-3 py-1 text-xs font-medium rounded-md 
                                        border border-red-500 text-red-600 bg-red-50 
                                        hover:bg-red-100 transition">
                                Hapus
                            </button>
                        </form>

                    </div>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Data kriteria belum tersedia
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>

        <div class="mt-4 flex justify-between items-center px-4 pb-4">

            <div class="text-sm text-gray-500">
                Showing {{ $kriterias->firstItem() }} 
                to {{ $kriterias->lastItem() }} 
                of {{ $kriterias->total() }} results
            </div>

            <div>
                {{ $kriterias->onEachSide(1)->links() }}
            </div>

        </div>

    </div>

    {{-- NOTE --}}
    <div class="text-sm text-gray-500">
        <strong>Catatan:</strong> Total bobot seluruh kriteria harus bernilai
        <span class="font-semibold">1 (100%)</span>
        agar perhitungan ARAS dapat dilakukan.
    </div>

</div>

@endsection