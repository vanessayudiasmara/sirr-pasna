@extends('layouts.app')

@section('title','Data Master - Jenis Kriteria')

@section('content')

<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Data Jenis Kriteria
            </h2>

            <p class="text-gray-500 text-sm">
                Kelola data jenis kriteria penilaian
            </p>
        </div>

        <a href="{{ route('jenis-kriteria.create') }}"
        class="bg-[color:var(--bpbd-blue)] text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
            + Tambah Data
        </a>

    </div>


    {{-- TABLE --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b">

                <tr class="text-gray-600">

                    <th class="px-5 py-3 font-semibold text-center w-16">
                        No
                    </th>

                    <th class="px-5 py-3 font-semibold text-left">
                        Jenis Kriteria
                    </th>

                    <th class="px-5 py-3 font-semibold text-center w-40">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($data as $i => $item)

                <tr class="border-b hover:bg-orange-50 transition">

                    <td class="px-5 py-3 text-center">
                        {{ $i + 1 }}
                    </td>

                    <td class="px-5 py-3">
                        {{ $item->nama_jenis_kriteria }}
                    </td>

                    <td class="px-5 py-3">

                        <div class="flex justify-center gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('jenis-kriteria.edit',$item->id) }}"
                            class="px-3 py-1 text-xs font-medium rounded-md bg-orange-600 text-white hover:bg-orange-700 transition">
                                Edit
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('jenis-kriteria.destroy',$item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Yakin hapus data ini?')"
                                    class="px-3 py-1 text-xs font-medium rounded-md border border-red-500 text-red-600 bg-red-50 hover:bg-red-100 transition">
                                    Hapus
                                </button>

                            </form>

                        </div>

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