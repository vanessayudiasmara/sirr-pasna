@extends('layouts.app')

@section('title', 'Detail Proyek')

@section('content')
<div class="space-y-6">

    {{-- JUDUL --}}
    <h2 class="text-xl font-semibold mb-6">
        Detail Proyek Rehabilitasi dan Rekonstruksi
    </h2>

    {{-- PROGRESS BAR --}}
@php
    $status = $alternatif->proyek->status ?? 'Dalam Tinjauan';

    $steps = [
        [
            'label' => 'Dalam Tinjauan',
            'fill'  => 'icons/tinjau-fill.png',
            'outline' => 'icons/tinjau-outline.png',
        ],
        [
            'label' => 'Dalam Proses',
            'fill'  => 'icons/proses-fill.png',
            'outline' => 'icons/proses-outline.png',
        ],
        [
            'label' => 'Selesai',
            'fill'  => 'icons/done-fill.png',
            'outline' => 'icons/done-outline.png',
        ],
    ];

    $currentStep = collect($steps)
        ->pluck('label')
        ->search($status);

    $isTertunda = $status === 'Tertunda';
@endphp

<div class="flex justify-center my-8">

    <div class="flex items-center gap-5">

        @if($isTertunda)

            {{-- TERTUNDA --}}
            <div class="flex flex-col items-center">

                <div class="w-14 h-14 rounded-full bg-red-600
                            flex items-center justify-center">

                    <img src="{{ asset('icons/tertunda-fill.png') }}"
                         class="w-8 h-8 object-contain">
                </div>

                <span class="text-sm mt-2 text-red-500 font-medium">
                    Tertunda
                </span>

            </div>

        @else

            @foreach ($steps as $i => $step)

                <div class="flex flex-col items-center">

                    {{-- ICON --}}
                    <div class="w-14 h-14 rounded-full
                                flex items-center justify-center

                        @if($i <= $currentStep)
                            bg-green-600
                        @else
                            bg-gray-300
                        @endif
                    ">

                        <img
                            src="{{ asset($i <= $currentStep ? $step['fill'] : $step['outline']) }}"
                            class="w-8 h-8 object-contain
                                
                            @if($i <= $currentStep)
                                opacity-100
                            @else
                                opacity-50
                            @endif
                        ">

                    </div>

                    {{-- LABEL --}}
                    <span class="text-sm mt-2

                        @if($i <= $currentStep)
                            text-green-700 font-semibold
                        @else
                            text-gray-500
                        @endif
                    ">
                        {{ $step['label'] }}
                    </span>

                </div>

                {{-- LINE --}}
                @if($i < count($steps)-1)

                    <div class="w-16 h-1 rounded-full

                        @if($i < $currentStep)
                            bg-green-600
                        @else
                            bg-gray-400
                        @endif
                    "></div>

                @endif

            @endforeach

        @endif

    </div>

</div>


    {{-- INFORMASI UMUM PROYEK --}}
    <div class="bg-white rounded-lg shadow mb-6 p-5">
        <h4 class="font-semibold mb-4">Informasi Umum Proyek</h4>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Tanggal Kejadian</p>
                <p>
                {{ \Carbon\Carbon::parse($alternatif->tanggal)->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Nama Proyek</p>
                <p>{{ $alternatif->nama_proyek }}</p>
            </div>

            <div>
                <p class="text-gray-500">Lokasi</p>
                <p>{{ $alternatif->kecamatan }} - {{ $alternatif->desa }}</p>
            </div>

            <div>
                <p class="text-gray-500">Jenis Bencana</p>
                <p>{{ $alternatif->jenis_bencana }}</p>
            </div>

            <div>
                <p class="text-gray-500">Volume Kerusakan</p>
                <p>
                    {{ $alternatif->volume_kerusakan }}
                    {{ $alternatif->satuan_volume }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Korban Terdampak</p>
                <p>{{ $alternatif->korban_terdampak ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Kewenangan Aset</p>
                <p>{{ $alternatif->kewenangan_aset ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Estimasi Biaya</p>
                <p>
                    Rp {{ number_format($alternatif->estimasi_biaya, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- DOKUMENTASI KERUSAKAN (CUPLIKAN) --}}
    @if ($alternatif->dokumentasis->count())
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <h4 class="font-semibold mb-2 text-sm">Dokumentasi Kerusakan</h4>

        <div class="flex gap-3 items-center">
            @foreach ($alternatif->dokumentasis->take(4) as $doc)
                <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank">
                    <img
                        src="{{ asset('storage/'.$doc->file_path) }}"
                        class="w-20 h-20 object-cover rounded border hover:opacity-80">
                </a>
            @endforeach

            @if ($alternatif->dokumentasis->count() > 4)
                <span class="text-xs text-gray-500">
                    +{{ $alternatif->dokumentasis->count() - 4 }} lainnya
                </span>
            @endif
        </div>
    </div>
    @endif

    {{-- UPDATE STATUS PROYEK --}}
    <div class="bg-white rounded-lg shadow p-5">

        <h4 class="font-semibold mb-4">
            Progress Proyek
        </h4>

        {{-- ========================= --}}
        {{-- SUPERADMIN --}}
        {{-- ========================= --}}
        @if(Auth::user()->role === 'superadmin')

        <form method="POST"
            action="{{ route('proyek.updateStatus', $alternatif->proyek->id) }}">

            @csrf
            @method('PATCH')

            <input type="hidden" name="from" value="{{ request('from') }}">

            <div class="grid grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="text-sm text-gray-600">
                        Status Proyek
                    </label>

                    <select name="status"
                        class="w-full border rounded px-3 py-2 text-sm">

                        @foreach (['Dalam Tinjauan', 'Dalam Proses', 'Selesai', 'Tertunda'] as $option)

                        <option value="{{ $option }}"
                            {{ $alternatif->proyek->status === $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>

                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600">
                        Tanggal Update
                    </label>

                    <input type="text"
                        disabled
                        value="{{ optional($alternatif->proyek->tanggal_update)->format('d/m/Y') ?? now()->format('d/m/Y') }}"
                        class="w-full border rounded px-3 py-2 text-sm bg-gray-100">
                </div>

            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-600">
                    Catatan Perkembangan
                </label>

                <textarea
                    name="keterangan"
                    rows="4"
                    class="w-full border rounded px-3 py-2 text-sm"
                    placeholder="Tambahkan catatan perkembangan proyek...">{{ $alternatif->proyek->keterangan }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">

                <a href="{{ request('from') === 'prioritas' ? route('prioritas.index') : route('proyek.index') }}"
                class="px-4 py-2 text-sm border border-gray-300 rounded text-gray-600 hover:bg-gray-100">
                    Kembali
                </a>

                <button type="submit"
                    class="px-5 py-2 text-sm rounded bg-gray-800 text-white hover:bg-gray-900 shadow">
                    Simpan
                </button>

            </div>

        </form>

        {{-- ========================= --}}
        {{-- USER (READ ONLY) --}}
        {{-- ========================= --}}
        @else

        <div class="space-y-4">

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm text-gray-500">
                        Status Proyek
                    </label>

                    <div class="mt-1 border rounded px-3 py-2 bg-gray-50 text-sm">
                        {{ $alternatif->proyek->status }}
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-500">
                        Tanggal Update
                    </label>

                    <div class="mt-1 border rounded px-3 py-2 bg-gray-50 text-sm">
                        {{ optional($alternatif->proyek->tanggal_update)->format('d/m/Y') ?? '-' }}
                    </div>
                </div>

            </div>

            <div>
                <label class="text-sm text-gray-500">
                    Catatan Perkembangan
                </label>

                <div class="mt-1 border rounded px-3 py-3 bg-gray-50 text-sm min-h-[120px]">
                    {{ $alternatif->proyek->keterangan ?? '-' }}
                </div>
            </div>

            <div class="flex justify-end mt-6">

                <a href="{{ route('prioritas.index') }}"
                class="px-4 py-2 text-sm border border-gray-300 rounded text-gray-600 hover:bg-gray-100">
                    Kembali
                </a>

            </div>

        </div>

        @endif

    </div>

</div>
@endsection
