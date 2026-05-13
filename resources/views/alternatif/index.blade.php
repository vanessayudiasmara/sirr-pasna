@extends('layouts.app')

@section('title', 'Data Kerusakan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Data Kerusakan dan Kerugian
            </h2>
            <p class="text-gray-500 text-sm">
                Daftar data rehabilitasi & rekonstruksi pascabencana
            </p>
        </div>

        @if(auth()->user()->role == 'superadmin')
        <a href="{{ route('alternatif.create') }}"
        class="bg-[color:var(--bpbd-blue)] text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
            + Tambah Data
        </a>
        @endif
    </div>

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- SEARCH BAR --}}
    <form method="GET" action="{{ route('alternatif.index') }}">
    <div class="bg-white p-4 rounded-xl shadow space-y-4">

        {{-- ROW 1 --}}
        <div class="grid grid-cols-12 gap-4">

            {{-- SEARCH --}}
            <div class="col-span-12 md:col-span-6">
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari data kerusakan..."
                    class="w-full rounded-lg border-gray-300 px-4 py-2 text-sm">
            </div>

            {{-- NAMA PROYEK --}}
            <div class="col-span-6 md:col-span-3">
                <select name="nama_proyek"
                    class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm">
                    
                    <option value="">
                        Semua Proyek
                    </option>

                    @foreach($proyeks as $p)
                        <option value="{{ $p->nama_proyek }}"
                            {{ request('nama_proyek') == $p->nama_proyek ? 'selected' : '' }}>
                            {{ $p->nama_proyek }}
                        </option>
                    @endforeach

                </select>
            </div>


            {{-- TAHUN --}}
            <div class="col-span-6 md:col-span-3">
                <select name="tahun"
                    class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm">

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
            </div>


            {{-- JENIS BENCANA --}}
            <div class="col-span-6 md:col-span-3">
                <select name="jenis_bencana"
                    class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm">

                    <option value="">
                        Semua Jenis Bencana
                    </option>

                    @foreach($jenisBencanas as $jb)
                        <option value="{{ $jb->nama_bencana }}"
                            {{ request('jenis_bencana') == $jb->nama_bencana ? 'selected' : '' }}>
                            {{ $jb->nama_bencana }}
                        </option>
                    @endforeach

                </select>
            </div>


            {{-- KEWENANGAN --}}
            <div class="col-span-6 md:col-span-3">
                <select name="kewenangan_aset"
                    class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm">

                    <option value="">
                        Semua Kewenangan
                    </option>

                    @foreach($kewenanganList as $k)
                        <option value="{{ $k }}"
                            {{ request('kewenangan_aset') == $k ? 'selected' : '' }}>
                            {{ $k }}
                        </option>
                    @endforeach

                </select>
            </div>


            {{-- STATUS --}}
            <div class="col-span-6 md:col-span-3">
                <select name="status"
                    class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm">

                    <option value="">
                        Semua Status
                    </option>

                    @foreach($statusList as $s)
                        <option value="{{ $s }}"
                            {{ request('status') == $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- BUTTON --}}
            <div class="col-span-6 md:col-span-3 flex gap-2 justify-end">
                <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm w-full md:w-auto">
                    Filter
                </button>

                <a href="{{ route('alternatif.index') }}"
                    class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                    Reset
                </a>
            </div>

        </div>

    </div>
    </form>


    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow overflow-hidden max-w-full">
    
    <div class="w-full overflow-x-auto">

        <table class="w-full text-sm text-gray-700">

            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-center">No</th>

                    <th class="px-4 py-3">Tanggal</th>

                    <th class="px-4 py-3">
                        Jenis <br> Bencana
                    </th>

                    <th class="px-4 py-3">Nama Proyek</th>

                    <th class="px-4 py-3">
                        Lokasi <br>
                        <span class="normal-case text-[10px] text-gray-400">
                            (Kec - Desa)
                        </span>
                    </th>

                    <th class="px-4 py-3">Jenis Infrastruktur</th>

                    <th class="px-4 py-3 text-center">
                        Volume <br> Kerusakan
                    </th>

                    <th class="px-6 py-3 text-center whitespace-nowrap">
                        Estimasi <br> Biaya (Rp)
                    </th>

                    <th class="px-4 py-3">
                        Kewenangan <br> Aset
                    </th>

                    <th class="px-4 py-3 text-center">
                        Korban <br> Terdampak
                    </th>

                    <th class="px-4 py-3 text-center">
                        Status
                    </th>

                    <th class="px-4 py-3 text-center w-[140px]">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y">

            @forelse($alternatifs as $i => $a)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3 text-center">
                        {{ $alternatifs->firstItem() + $i }}
                    </td>

                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $a->jenis_bencana }}
                    </td>

                    <td class="px-4 py-3 font-medium">
                        {{ $a->nama_proyek }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $a->kecamatan }} - {{ $a->desa }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $a->jenis_infrastruktur }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ $a->volume_kerusakan }}
                        <span class="text-gray-500 text-xs">
                            {{ $a->satuan_volume }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-right font-semibold whitespace-nowrap text-gray-800">
                        Rp {{ number_format($a->estimasi_biaya,0,',','.') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $a->kewenangan_aset }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ $a->korban_terdampak ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        @php
                            $status = $a->proyek->status ?? $a->status;

                            $color = match($status) {
                                'Selesai' => 'bg-green-600',
                                'Dalam Proses' => 'bg-yellow-500',
                                'Tertunda' => 'bg-red-600',
                                default => 'bg-gray-400'
                            };
                        @endphp

                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $color }} inline-block flex-shrink-0"></span>
                            <span class="text-gray-700 text-sm">
                                {{ $status }}
                            </span>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">

                            @if(auth()->user()->role == 'superadmin')

                                <a href="{{ route('alternatif.edit', $a->id) }}"
                                    class="px-3 py-1 text-xs font-medium rounded-md bg-orange-600 text-white hover:bg-orange-700 transition">
                                    Edit
                                </a>

                                <form action="{{ route('alternatif.destroy', $a->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin hapus data ini?')"
                                        class="px-3 py-1 text-xs font-medium rounded-md border border-red-500 text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </form>

                            @else

                            <a href="{{ route('alternatif.show', $a->id) }}"
                                class="px-3 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                Detail
                            </a>

                            @endif
                        </div>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="12" class="text-center py-6 text-gray-500">
                        Data kerusakan belum tersedia
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>
    </div>

    <div class="mt-4 flex justify-between items-center px-4 pb-4">

        <div class="text-sm text-gray-500">
            Showing {{ $alternatifs->firstItem() }} 
            to {{ $alternatifs->lastItem() }} 
            of {{ $alternatifs->total() }} results
        </div>

        <div>
            {{ $alternatifs->onEachSide(1)->links() }}
        </div>

    </div>

</div>

@endsection