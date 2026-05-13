@extends('layouts.app')

@section('title', 'Manajemen Proyek')
@section('content')
<div class="space-y-6">

    {{-- TITLE --}}
    <h2 class="text-2xl font-bold text-gray-800">
        Manajemen Proyek Rehabilitasi Rekonstruksi
    </h2>

    {{-- FILTER BAR --}}
    <form method="GET" action="{{ route('proyek.index') }}">

    <div class="bg-white p-4 rounded-xl shadow flex flex-wrap gap-4 items-center">

        {{-- SEARCH --}}
        <input type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari data proyek..."
        class="w-72 rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">


        {{-- JENIS BENCANA --}}
        <select name="jenis_bencana"
        class="w-52 rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">

            <option value="">
                Semua Jenis Bencana
            </option>

            @foreach($jenisBencanas as $jb)
                <option value="{{ $jb }}"
                    {{ request('jenis_bencana') == $jb ? 'selected' : '' }}>
                    {{ $jb }}
                </option>
            @endforeach

        </select>


        {{-- TAHUN --}}
        <select name="tahun"
        class="w-36 rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">

            <option value="">
                Semua Tahun
            </option>

            @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}"
                    {{ request('tahun') == $tahun ? 'selected' : '' }}>
                    {{ $tahun }}
                </option>
            @endforeach

        </select>


        {{-- STATUS --}}
        <select name="status"
        class="w-44 rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">

            <option value="">
                Semua Status
            </option>

            @foreach($statusList as $status)
                <option value="{{ $status }}"
                    {{ request('status') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach

        </select>

        {{-- BUTTON --}}
        <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg text-sm font-medium">
            Filter
        </button>

        <a href="{{ route('proyek.index') }}"
        class="text-sm text-gray-500 hover:text-gray-700">
            Reset
        </a>

    </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm text-gray-700">

            {{-- HEADER --}}
           <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Tanggal</th>
                    <th class="px-6 py-3 text-center">Jenis Bencana</th>
                    <th class="px-6 py-3 text-center">Nama Proyek</th>
                    <th class="px-6 py-3 text-center">
                        Lokasi<br><span class="text-[10px]">(Kec - Desa)</span>
                    </th>
                    <th class="px-6 py-3 text-center">Tanggal Update</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y divide-gray-100">

            @forelse ($alternatifs as $i => $alt)
                @php
                    $proyek = $alt->proyek;
                    $status = $proyek->status ?? 'Dalam Tinjauan';

                    $color = match($status) {
                        'Selesai' => 'bg-green-600',
                        'Dalam Proses' => 'bg-yellow-500',
                        'Tertunda' => 'bg-red-600',
                        default => 'bg-gray-400'
                    };
                @endphp

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-6 py-4 text-center font-medium">
                        {{ $alternatifs->firstItem() + $i }}
                    </td>

                    <td class="px-6 py-4 text-center">
                       {{ \Carbon\Carbon::parse($alt->tanggal)->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $alt->jenis_bencana }}
                    </td>

                    <td class="px-6 py-4 font-medium">
                        {{ $alt->nama_proyek }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $alt->kecamatan }} - {{ $alt->desa }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        {{ $proyek->tanggal_update ?? '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $color }}"></span>
                            <span class="text-gray-700">{{ $status }}</span>
                        </div>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('proyek.show', $alt->id) }}?from=manajemen"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-xs transition">
                            Detail
                        </a>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="8" class="px-6 py-6 text-center text-gray-400">
                        Data proyek belum tersedia
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4 flex justify-between items-center px-6 pb-4">

            <div class="text-sm text-gray-500">
                Showing {{ $alternatifs->firstItem() }} to {{ $alternatifs->lastItem() }} of {{ $alternatifs->total() }} results
            </div>

            <div>
                {{ $alternatifs->onEachSide(1)->links() }}
            </div>

        </div>

    </div>

</div>
@endsection