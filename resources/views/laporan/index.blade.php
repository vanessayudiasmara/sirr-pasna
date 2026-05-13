@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<div class="space-y-6">

    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Export Laporan Rehabilitasi & Rekonstruksi
        </h2>
        <p class="text-gray-500">
            Pilih periode laporan yang ingin diunduh
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

    <form method="POST" action="{{ route('laporan.export') }}"
      class="flex gap-6 items-end flex-wrap">
    @csrf

    {{-- BULAN --}}
    <div class="flex flex-col gap-1">
        <label class="text-sm text-gray-600">Bulan</label>
        <select name="bulan" id="bulan"
                class="border rounded px-3 py-2 w-40">
            <option value="">Semua Bulan</option>
            @foreach($months as $key => $month)
                <option value="{{ $key }}">{{ $month }}</option>
            @endforeach
        </select>
    </div>

    {{-- TAHUN --}}
    <div class="flex flex-col gap-1">
        <label class="text-sm text-gray-600">Tahun</label>
        <select name="tahun" id="tahun"
                class="border rounded px-3 py-2 w-32">
            @for ($y = date('Y'); $y >= 2020; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
            @endfor
        </select>
    </div>

    {{-- BUTTON --}}
    <div>
        <button type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Export Excel
        </button>
    </div>

</form>
</div>

<div id="preview-container" class="mt-6 bg-white rounded-xl shadow p-6 hidden">

    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold">
            Preview Data Laporan
        </h3>

        <span class="text-xs text-gray-500">
            Menampilkan 10 data pertama
        </span>
    </div>

    <div class="overflow-x-auto border rounded-lg">

        <table class="w-full text-sm border border-gray-300">

            <thead class="bg-gray-200 text-gray-700 font-semibold">
            <tr>
                <th class="px-3 py-2 text-center">No</th>
                <th class="px-3 py-2">Tanggal</th>
                <th class="px-3 py-2">Jenis Bencana</th>
                <th class="px-3 py-2">Kecamatan</th>
                <th class="px-3 py-2">Desa</th>
                <th class="px-3 py-2">Kerusakan</th>
                <th class="px-3 py-2">Vol. Kerusakan</th>
                <th class="px-3 py-2">Kebutuhan</th>
                <th class="px-3 py-2">Vol. Kebutuhan</th>
                <th class="px-3 py-2">Estimasi Masyarakat</th>
                <th class="px-3 py-2">Estimasi Pemerintah</th>
                <th class="px-3 py-2">Kewenangan</th>
            </tr>
            </thead>

            <tbody id="preview-body"></tbody>

        </table>

    </div>

</div>


<script>
document.addEventListener("DOMContentLoaded", function(){

    const bulan = document.getElementById('bulan');
    const tahun = document.getElementById('tahun');
    const previewContainer = document.getElementById('preview-container');
    const previewBody = document.getElementById('preview-body');

    function formatAngka(value){
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 3,
            maximumFractionDigits: 3
        }).format(value);
    }

    function formatTanggal(tgl){
        if(!tgl) return '-';
        let date = new Date(tgl);
        return date.toLocaleDateString('id-ID');
    }

    function formatRupiah(value){
        if(!value) return '-';
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
    }

    function getStatusColor(status){
        if(status === 'Selesai') return 'text-green-600';
        if(status === 'Dalam Proses') return 'text-yellow-600';
        if(status === 'Tertunda') return 'text-red-600';
        return 'text-gray-600';
    }

    function loadPreview(){

        previewBody.innerHTML = `
            <tr>
                <td colspan="12" class="text-center py-4 text-gray-400">
                    Loading...
                </td>
            </tr>
        `;

        fetch(`/laporan/preview?bulan=${bulan.value}&tahun=${tahun.value}`)
        .then(res => res.json())
        .then(data => {

            previewBody.innerHTML = '';

            if(data.length === 0){
                previewBody.innerHTML = `
                    <tr>
                        <td colspan="12" class="text-center py-6 text-gray-400">
                            Tidak ada data
                        </td>
                    </tr>
                `;
            }

            data.forEach((item, index) => {

                let alt = item.alternatif;

                previewBody.innerHTML += `
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2 text-center">${index + 1}</td>
                    <td class="px-3 py-2">${formatTanggal(alt?.tanggal)}</td>
                    <td class="px-3 py-2">${alt?.jenis_bencana ?? '-'}</td>
                    <td class="px-3 py-2">${alt?.kecamatan ?? '-'}</td>
                    <td class="px-3 py-2">${alt?.desa ?? '-'}</td>
                    <td class="px-3 py-2">${alt?.jenis_infrastruktur ?? '-'}</td>
                    <td class="px-3 py-2">
                        ${alt?.volume_kerusakan ?? '-'} ${alt?.satuan_volume ?? ''}
                    </td>
                    <td class="px-3 py-2">${alt?.jenis_infrastruktur ?? '-'}</td>
                    <td class="px-3 py-2">
                        ${alt?.volume_kerusakan ?? '-'} ${alt?.satuan_volume ?? ''}
                    </td>
                    <td class="px-3 py-2 text-right">
                        ${formatRupiah(alt?.estimasi_masyarakat)}
                    </td>
                    <td class="px-3 py-2 text-right">
                        ${formatRupiah(alt?.estimasi_pemerintah)}
                    </td>
                    <td class="px-3 py-2">${alt?.kewenangan_aset ?? '-'}</td>
                </tr>
                `;
            });

            previewContainer.classList.remove('hidden');
        })
        .catch(error => {
            console.error(error);

            previewBody.innerHTML = `
                <tr>
                    <td colspan="12" class="text-center py-4 text-red-500">
                        Gagal load preview
                    </td>
                </tr>
            `;

            previewContainer.classList.remove('hidden');
        });
    }

    bulan.addEventListener('change', loadPreview);
    tahun.addEventListener('change', loadPreview);

    loadPreview();

});

</script>   

@endsection