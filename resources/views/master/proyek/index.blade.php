@extends('layouts.app')

@section('title','Data Master - Proyek')

@section('content')

<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Data Proyek
            </h2>

            <p class="text-gray-500 text-sm">
                Kelola data master proyek rehabilitasi dan rekonstruksi
            </p>
        </div>

        <a href="{{ route('master-proyek.create') }}"
        class="bg-[color:var(--bpbd-blue)] text-white px-4 py-2 rounded-lg text-sm hover:opacity-90 transition">
            + Tambah Jenis Proyek
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
                        Nama Proyek
                    </th>

                    <th class="px-5 py-3 font-semibold text-center w-40">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($proyeks as $i => $p)

                <tr class="border-b hover:bg-orange-50/40 transition">

                    <td class="px-5 py-3 text-gray-700">
                        {{ $proyeks->firstItem() + $i }}
                    </td>

                    <td class="px-5 py-3 font-medium text-gray-700">
                        {{ $p->nama_proyek }}
                    </td>

                    <td class="px-5 py-3">

                        <div class="flex justify-center gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('master-proyek.edit',$p->id) }}"
                            class="px-3 py-1 text-xs font-medium rounded-md bg-orange-500 text-white hover:bg-orange-600 transition">
                                Edit
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('master-proyek.destroy',$p->id) }}" method="POST">
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
                    <td colspan="3"
                    class="px-5 py-8 text-center text-gray-400">
                        Data proyek belum tersedia
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>


        {{-- PAGINATION --}}
        <div class="flex justify-between items-center px-5 py-3 bg-white">

            <div class="text-sm text-gray-500">
                Showing {{ $proyeks->firstItem() }}
                to {{ $proyeks->lastItem() }}
                of {{ $proyeks->total() }} results
            </div>

            <div>
                {{ $proyeks->onEachSide(1)->links() }}
            </div>

        </div>

    </div>

</div>

@endsection