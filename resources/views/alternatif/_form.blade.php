@php
    $readonly = $readonly ?? false;
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

<div class="bg-white rounded-xl shadow p-6">

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-600 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= INFORMASI UMUM ================= --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">
            Informasi Umum
        </h3>
        <div class="border-b mb-4"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Tanggal --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Tanggal Kejadian
                </label>
                <input type="date" name="tanggal"
                {{ $readonly ? 'disabled' : '' }}
                    value="{{ old('tanggal', $alternatif?->tanggal) }}"
                    class="w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200">
            </div>

            {{-- Jenis Bencana --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Jenis Bencana
                </label>
                <select name="jenis_bencana"
                {{ $readonly ? 'disabled' : '' }}
                    class="w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200">
                    <option value="" disabled selected hidden>Pilih</option>
                    @foreach ($jenisBencanas as $item)
                    <option value="{{ $item->nama_bencana }}"
                    {{ old('jenis_bencana', $alternatif?->jenis_bencana) == $item->nama_bencana ? 'selected' : '' }}>
                    {{ $item->nama_bencana }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Dokumentasi --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Dokumentasi Kerusakan
                </label>
            
                @if(!empty($alternatif) && $alternatif->dokumentasis->isNotEmpty())
                <div class="flex flex-wrap gap-3 mb-3">
                    @foreach($alternatif->dokumentasis as $doc)
                        <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank">
                            <img src="{{ asset('storage/'.$doc->file_path) }}"
                                class="rounded border"
                                style="width:100px">
                        </a>
                    @endforeach
                </div>
            @endif       

                <input type="file" name="dokumentasi[]" multiple accept="image/*" id="dokumentasi"
                    {{ $readonly ? 'disabled' : '' }}
                    class="w-full text-sm border rounded-lg p-2 bg-gray-50">
            </div>

        </div>

        {{-- Row 2 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Nama Proyek
                </label>
                <select id="proyek" name="nama_proyek"
                     {{ $readonly ? 'disabled' : '' }}
                    class="w-full rounded-lg border-gray-300">

                    <option value="">Pilih Proyek</option>

                    @foreach($proyeks as $p)
                        <option value="{{ $p->nama_proyek }}"
                            {{ old('nama_proyek', $alternatif?->nama_proyek) == $p->nama_proyek ? 'selected' : '' }}>
                            {{ $p->nama_proyek }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full">
                <label class="block text-sm text-gray-600 mb-1">
                    Kecamatan
                </label>

                <select id="kecamatan" name="kecamatan"
                {{ $readonly ? 'disabled' : '' }}
                    class="select-search w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200">

                    <option value="" disabled selected hidden>Pilih Kecamatan</option>

                    @foreach ($kecamatans as $kec)
                    <option 
                        value="{{ $kec->nama_kecamatan }}"
                        data-id="{{ $kec->id }}"
                    {{ old('kecamatan',$alternatif?->kecamatan)==$kec->nama_kecamatan?'selected':'' }}>
                    {{ $kec->nama_kecamatan }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full">
                <label class="block text-sm text-gray-600 mb-1">
                    Desa / Kelurahan
                </label>

                <select id="desa"
                    name="desa"
                    {{ $readonly ? 'disabled' : '' }}
                    class="select-search w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200">

                    <option value="">Pilih Desa</option>

                    @foreach ($desas as $desa)

                    <option 
                    value="{{ $desa->nama_desa }}"
                    data-kecamatan="{{ $desa->kecamatan_id }}"
                    {{ old('desa',$alternatif?->desa)==$desa->nama_desa?'selected':'' }}>

                    {{ $desa->nama_desa }}

                    </option>

                    @endforeach

                </select>
            </div>

        </div>
    </div>


    {{-- ================= DATA KERUSAKAN ================= --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">
            Data Kerusakan dan Kerugian
        </h3>
        <div class="border-b mb-4"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Jenis Infrastruktur --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Jenis Infrastruktur
                </label>

                @php
                $infra = \App\Models\Kriteria::where('nama_kriteria','Jenis Infrastruktur')
                    ->with('subKriterias')
                    ->first();
                @endphp

                <select name="jenis_infrastruktur"
                {{ $readonly ? 'disabled' : '' }}
                class="w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200">

                    <option value="" disabled selected hidden>Pilih</option>

                    @foreach($infra?->subKriterias ?? [] as $item)

                    <option value="{{ $item->nama }}"
                    {{ old('jenis_infrastruktur',$alternatif?->jenis_infrastruktur) == $item->nama ? 'selected' : '' }}>

                    {{ $item->nama }}

                    </option>

                    @endforeach

                </select>
            </div>

            {{-- Volume --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Volume Kerusakan
                </label>
                <div class="flex gap-2">
                    <input type="number" step="0.01"
                        name="volume_kerusakan"
                        {{ $readonly ? 'disabled' : '' }}
                        value="{{ old('volume_kerusakan', $alternatif?->volume_kerusakan) }}"
                        class="w-full rounded-lg border-gray-300">
                    <select name="satuan_volume"
                    {{ $readonly ? 'disabled' : '' }}
                        class="w-28 rounded-lg border-gray-300">
                        <option value="" disabled selected hidden>Satuan</option>
                        @foreach ($satuans as $satuan)
                            <option value="{{ $satuan->simbol }}"
                            {{ old('satuan_volume',$alternatif?->satuan_volume)==$satuan->simbol?'selected':'' }}>
                            {{ $satuan->simbol }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Kewenangan Aset --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Kewenangan Aset
                </label>

                @php
                $aset = \App\Models\Kriteria::where('nama_kriteria','Kewenangan Aset')
                    ->with('subKriterias')
                    ->first();
                @endphp

                <select id="kewenangan_aset" name="kewenangan_aset"
                {{ $readonly ? 'disabled' : '' }}
                class="w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200">

                    <option value="" disabled selected hidden>Pilih</option>

                    @foreach($aset?->subKriterias ?? [] as $item)

                    <option value="{{ $item->nama }}"
                    {{ old('kewenangan_aset',$alternatif?->kewenangan_aset)==$item->nama?'selected':'' }}>

                    {{ $item->nama }}

                    </option>

                    @endforeach

                </select>
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Estimasi Kebutuhan Masyarakat (Rp)
                </label>
                <input id="estimasi_masyarakat" type="text" name="estimasi_masyarakat"
                {{ $readonly ? 'disabled' : '' }}
                    value="{{ old('estimasi_masyarakat', $alternatif?->estimasi_masyarakat) }}"
                    class="w-full rounded-lg border-gray-300 text-right rupiah">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Estimasi Kebutuhan Pemerintah (Rp)
                </label>
                <input id="estimasi_pemerintah" type="text" name="estimasi_pemerintah"
                {{ $readonly ? 'disabled' : '' }}
                    value="{{ old('estimasi_pemerintah', $alternatif?->estimasi_pemerintah) }}"
                    class="w-full rounded-lg border-gray-300 text-right rupiah">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Jumlah Korban Terdampak
                </label>
                <input type="number" name="korban_terdampak"
                {{ $readonly ? 'disabled' : '' }}
                    value="{{ old('korban_terdampak', $alternatif?->korban_terdampak) }}"
                    class="w-full rounded-lg border-gray-300">
            </div>

        </div>

        <div class="mt-6">
            <label class="block text-sm text-gray-600 mb-1">
                Keterangan
            </label>
           <textarea name="keterangan" rows="3"
           {{ $readonly ? 'disabled' : '' }}
            class="w-full rounded-lg border-gray-300">{{ old('keterangan', $alternatif?->keterangan) }}</textarea>
        </div>
    </div>

    {{-- BUTTON --}}
    <div class="flex justify-end gap-3 mt-8">

        <a href="{{ route('alternatif.index') }}"
        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
            {{ $readonly ? 'Kembali' : 'Batal' }}
        </a>

        @if(!$readonly)
        <button type="submit"
            class="px-5 py-2 rounded-lg text-white
                bg-[color:var(--bpbd-blue)] hover:opacity-90">
            {{ $submitText }}
        </button>
        @endif

    </div>

</div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function formatRupiah(el) {
        let value = el.value.replace(/[^,\d]/g, '');

        if (!value) {
            el.value = '';
            return;
        }

        let sisa = value.length % 3;
        let rupiah = value.substr(0, sisa);
        let ribuan = value.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            rupiah += (sisa ? '.' : '') + ribuan.join('.');
        }

        el.value = rupiah;
    }

    document.querySelectorAll('.rupiah').forEach(function(input) {

        if (input.value && input.value !== '0') {
            formatRupiah(input);
        }

        input.addEventListener('focus', function () {
            if (this.value === '0') {
                this.value = '';
            }
        });

        input.addEventListener('input', function () {
            formatRupiah(this);
        });

    });

});
</script>

<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    // ===== PROYEK =====
    const proyekSelect = new TomSelect("#proyek", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "Cari atau pilih proyek...",
    });

    // ===== KECAMATAN - DESA =====
    let kecamatan = document.querySelector("#kecamatan");
    let desa = document.querySelector("#desa");

    let desaOptions = [...desa.options];

    const desaSelect = new TomSelect("#desa",{create:false});
    const kecamatanSelect = new TomSelect("#kecamatan",{create:false});

    // ===== READONLY MODE =====
    @if($readonly)
        proyekSelect.disable();
        kecamatanSelect.disable();
        desaSelect.disable();
    @endif

    kecamatanSelect.on("change", function(value){

        let kecamatanId = kecamatan.selectedOptions[0]?.dataset.id;

        desaSelect.clear();
        desaSelect.clearOptions();

        desaOptions.forEach(function(option){

            if(option.dataset.kecamatan == kecamatanId){

                desaSelect.addOption({
                    value: option.value,
                    text: option.text
                });

            }

        });

        desaSelect.refreshOptions(false);

    });

    // ===== KEWENANGAN =====
    const kewenangan = document.getElementById('kewenangan_aset');
    const masyarakat = document.getElementById('estimasi_masyarakat');
    const pemerintah = document.getElementById('estimasi_pemerintah');

    function toggleEstimasi(value) {

        // readonly jangan diutak atik
        if (@json($readonly)) return;

        if (value && value.toLowerCase().includes('pemerintah')) {

            pemerintah.disabled = false;
            masyarakat.disabled = true;
            masyarakat.value = '';

        } 
        else if (value && value.toLowerCase().includes('masyarakat')) {

            masyarakat.disabled = false;
            pemerintah.disabled = true;
            pemerintah.value = '';

        } 
        else {

            masyarakat.disabled = false;
            pemerintah.disabled = false;

        }
    }

    // normal select
    kewenangan.addEventListener('change', function(){
        toggleEstimasi(this.value);
    });

    // kalau pakai TomSelect
    if (kewenangan.tomselect) {

        kewenangan.tomselect.on('change', function(value){
            toggleEstimasi(value);
        });

    }

    // initial load
    toggleEstimasi(kewenangan.value);

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    const input = document.getElementById('dokumentasi');

    if(!input) return;

    let filesArray = [];

    input.addEventListener('change', function(e){

        const newFiles = Array.from(e.target.files);

        newFiles.forEach(file => {

            // validasi tipe gambar
            if (!file.type.startsWith('image/')) {
                alert('Hanya file gambar yang diperbolehkan!');
                return;
            }

            filesArray.push(file);

        });

        // rebuild file list
        const dt = new DataTransfer();

        filesArray.forEach(file => dt.items.add(file));

        input.files = dt.files;

    });

});
</script>

<style>
.ts-wrapper{
    width:100%;
}

.ts-wrapper .ts-control{
    width:100%;
    border-radius:0.5rem;
    border:1px solid rgb(209 213 219);
    padding:8px 12px;
    min-height:42px;
}

/* disabled field */
input:disabled,
select:disabled,
textarea:disabled {
    background-color: #f3f4f6 !important;
    color: #6b7280 !important;
    cursor: not-allowed;
    opacity: 1 !important;
}

/* disabled TomSelect */
.ts-control.disabled,
.ts-wrapper.disabled .ts-control {
    background-color: #f3f4f6 !important;
    color: #6b7280 !important;
    opacity: 1 !important;
    cursor: not-allowed !important;
}

</style>