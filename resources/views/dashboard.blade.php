@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        Selamat Datang di SIRR-PASNA!
    </h2>
    <p class="text-gray-500">
        Sistem Informasi Rehabilitasi Rekonstruksi Pascabencana
    </p>
</div>

{{-- CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Total Data Kerusakan</p>
        <p class="text-3xl font-bold text-[color:var(--bpbd-orange)]">
            {{ $totalKerusakan }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Total Prioritas Proyek</p>
        <p class="text-3xl font-bold text-[color:var(--bpbd-blue)]">
            {{ $totalPrioritas }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Jumlah Proyek Selesai</p>
        <p class="text-3xl font-bold text-green-500">
            {{ $proyekSelesai }}
        </p>
    </div>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between mb-4">
        <h3 class="font-semibold">
            Tabel Peringkat Prioritas Proyek
        </h3>

        <a href="{{ route('prioritas.index') }}"
           class="px-4 py-2 rounded-lg text-white
                  bg-[color:var(--bpbd-blue)] hover:opacity-90">
            Lihat Semua
        </a>
    </div>

    <table class="w-full text-sm">

    <thead class="border-b text-gray-600 bg-gray-50 text-xs uppercase tracking-wide">
        <tr>
            <th class="py-3 text-center w-16">RANKING</th>
            <th class="text-center">NAMA PROYEK</th>
            <th class="text-center">
                LOKASI
                <div class="text-[10px] text-gray-500 font-semibold">
                    (Kecamatan - Desa)
                </div>
            </th>
            <th class="text-center">
                JENIS INFRASTRUKTUR
            </th>
            <th class="text-center">
                NILAI PRIORITAS
            </th>
            <th class="text-center">
                STATUS
            </th>
        </tr>
    </thead>

    <tbody>

        @forelse($rankingProyek as $item)

            <tr class="border-b hover:bg-gray-50 transition">

                {{-- Ranking --}}
                <td class="py-3 text-center font-semibold">
                    {{ $item->ranking }}
                </td>

                {{-- Nama Proyek --}}
                <td class="py-3 text-left font-semibold">
                    {{ $item->alternatif->nama_proyek ?? '-' }}
                </td>

                {{-- Lokasi --}}
                <td class="py-3 text-center">
                    {{ $item->alternatif->kecamatan ?? '-' }} -
                    {{ $item->alternatif->desa ?? '-' }}
                </td>

                {{-- Jenis Infrastruktur --}}
                <td class="py-3 text-center">
                    {{ $item->alternatif->jenis_infrastruktur ?? '-' }}
                </td>

                {{-- Nilai --}}
                <td class="py-3 text-center font-bold text-blue-600">
                    {{ number_format($item->nilai_preferensi, 3, ',', '.') }}
                </td>

                {{-- Status --}}
                <td class="py-3 flex justify-center">

                    @php
                        $status = $item->alternatif->proyek->status ?? 'Dalam Tinjauan';
                    @endphp

                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full
                            @if($status === 'Selesai') bg-green-600
                            @elseif($status === 'Dalam Proses') bg-yellow-500
                            @elseif($status === 'Tertunda') bg-red-600
                            @else bg-gray-500
                            @endif">
                        </span>

                        {{ $status }}
                    </span>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6"
                    class="py-8 text-center text-gray-400">
                    Data prioritas proyek belum tersedia
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

</div>

@endsection
