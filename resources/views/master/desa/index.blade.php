@extends('layouts.app')

@section('title','Data Master - Desa')

@section('content')

<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Data Desa / Kelurahan
            </h2>

            <p class="text-gray-500 text-sm">
                Kelola data master desa dan kelurahan
            </p>
        </div>

        <a href="{{ route('desa.create') }}"
        class="bg-[color:var(--bpbd-blue)] text-white px-4 py-2 rounded-lg text-sm hover:opacity-90 transition">
            + Tambah Desa
        </a>

    </div>


    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl overflow-hidden border border-gray-100">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b">

                <tr class="text-left text-gray-600">

                    <th class="px-5 py-3 font-semibold w-16">
                        No
                    </th>

                    <th class="px-5 py-3 font-semibold">
                        Kecamatan
                    </th>

                    <th class="px-5 py-3 font-semibold">
                        Nama Desa
                    </th>

                    <th class="px-5 py-3 font-semibold text-center w-40">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($desas as $i => $desa)

                <tr class="border-b hover:bg-orange-50/40 transition">

                    <td class="px-5 py-3 text-gray-700">
                        {{ $desas->firstItem() + $i }}
                    </td>

                    <td class="px-5 py-3 text-gray-700">
                        {{ $desa->kecamatan->nama_kecamatan }}
                    </td>

                    <td class="px-5 py-3 font-medium text-gray-700">
                        {{ $desa->nama_desa }}
                    </td>

                    <td class="px-5 py-3">

                        <div class="flex justify-center gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('desa.edit',$desa->id) }}"
                            class="px-3 py-1 text-xs font-medium rounded-md bg-orange-500 text-white hover:bg-orange-600 transition">
                                Edit
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('desa.destroy',$desa->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                onclick="return confirm('Yakin hapus data ini?')"
                                class="px-3 py-1 text-xs font-medium rounded-md border border-red-300 text-red-600 bg-red-50 hover:bg-red-100 transition">
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4"
                    class="px-5 py-8 text-center text-gray-400">
                        Data desa belum tersedia
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>


        {{-- PAGINATION --}}
        <div class="flex justify-between items-center px-5 py-3 bg-white">

            <div class="text-sm text-gray-500">
                Showing {{ $desas->firstItem() }}
                to {{ $desas->lastItem() }}
                of {{ $desas->total() }} results
            </div>

            <div>
                {{ $desas->onEachSide(1)->links() }}
            </div>

        </div>

    </div>

</div>

@endsection