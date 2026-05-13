@extends('layouts.app')

@section('title', 'Daftar Prioritas Proyek')

@section('content')

<div class="space-y-6">

    {{-- ========================= --}}
    {{-- TITLE --}}
    {{-- ========================= --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Daftar Prioritas Penanganan Rehabilitasi dan Rekonstruksi
        </h2>
    </div>


    {{-- ========================= --}}
    {{-- SUMMARY CARDS --}}
    {{-- ========================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        {{-- Selesai --}}
        <div class="bg-white shadow-md rounded-xl p-6">
            <p class="text-2xl font-bold text-green-600">
                {{ $selesai }}
            </p>
            <p class="text-gray-500">
                Selesai
            </p>
        </div>

        {{-- Dalam Tinjauan --}}
        <div class="bg-white shadow-md rounded-xl p-6">
            <p class="text-2xl font-bold text-orange-500">
                {{ $dalamTinjauan }}
            </p>
            <p class="text-gray-500">
                Dalam Tinjauan
            </p>
        </div>

        {{-- Dalam Proses --}}
        <div class="bg-white shadow-md rounded-xl p-6">
            <p class="text-2xl font-bold text-blue-500">
                {{ $diproses }}
            </p>
            <p class="text-gray-500">
                Dalam Proses
            </p>
        </div>

        {{-- Tertunda --}}
        <div class="bg-white shadow-md rounded-xl p-6">
            <p class="text-2xl font-bold text-red-500">
                {{ $tertunda }}
            </p>
            <p class="text-gray-500">
                Tertunda
            </p>
        </div>

    </div>


    {{-- ========================= --}}
    {{-- FILTER BAR --}}
    {{-- ========================= --}}
    <form method="GET" action="{{ route('prioritas.index') }}">
        
    <div class="bg-white p-4 rounded-xl shadow flex flex-wrap gap-4 items-center">

        {{-- SEARCH --}}
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama proyek atau lokasi..."
            class="w-96 rounded-lg border-gray-300 px-300 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
        />

        {{-- TAHUN --}}
        <select name="tahun"
        class="w-40 border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">

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
        class="w-44 border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">

            <option value="">
                Semua Status
            </option>

            <option value="Dalam Tinjauan"
                {{ request('status') == 'Dalam Tinjauan' ? 'selected' : '' }}>
                Dalam Tinjauan
            </option>

            <option value="Dalam Proses"
                {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>
                Dalam Proses
            </option>

            <option value="Selesai"
                {{ request('status') == 'Selesai' ? 'selected' : '' }}>
                Selesai
            </option>

            <option value="Tertunda"
                {{ request('status') == 'Tertunda' ? 'selected' : '' }}>
                Tertunda
            </option>

        </select>

        {{-- BUTTON FILTER --}}
        <button
            type="submit"
            class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg text-sm font-medium">
            Filter
        </button>

        {{-- RESET FILTER --}}
        <a href="{{ route('prioritas.index') }}"
        class="text-sm text-gray-500 hover:text-gray-700">
            Reset
        </a>

    </div>

    </form>


    {{-- ========================= --}}
    {{-- TABLE --}}
    {{-- ========================= --}}
    <div class="bg-white shadow-md rounded-xl overflow-hidden">

        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-center">Ranking</th>
                    <th class="px-6 py-3 text-center">Tanggal</th>
                    <th class="px-6 py-3 text-center">Nama Proyek</th>
                    <th class="px-6 py-3 text-center">Lokasi</th>
                    <th class="px-6 py-3 text-center">Jenis Infrastruktur</th>
                    <th class="px-6 py-3 text-center">Nilai Prioritas</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($data as $item)

                <tr class="hover:bg-gray-50 transition">

                    <td class="text-center font-semibold">
                        {{ $item->ranking }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($item->alternatif->tanggal)->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4 font-medium">
                        {{ $item->alternatif->nama_proyek ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->alternatif->lokasi ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->alternatif->jenis_infrastruktur ?? '-' }}
                    </td>

                    <td class="px-6 py-4 font-semibold text-blue-600">
                        {{ number_format($item->nilai_preferensi, 3, ',', '.') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4">

                        @php
                            $status = $item->alternatif->proyek->status ?? 'Dalam Tinjauan';

                            $color = match($status) {
                                'Selesai' => 'bg-green-600',
                                'Dalam Proses' => 'bg-yellow-500',
                                'Tertunda' => 'bg-red-600',
                                default => 'bg-gray-500'
                            };
                        @endphp

                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $color }}"></span>
                            {{ $status }}
                        </div>

                    </td>

                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('proyek.show', $item->alternatif->id) }}?from=prioritas"
                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm">
                            Detail
                        </a>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8" class="py-10 text-center text-gray-400">
                        Data prioritas proyek belum tersedia
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>

        <div class="mt-4 flex justify-between items-center px-6 pb-4">

                <div class="text-sm text-gray-500">
                    Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} results
                </div>

                <div>
                    {{ $data->onEachSide(1)->links() }}
                </div>

        </div>

</div>
    
</div>

@endsection
