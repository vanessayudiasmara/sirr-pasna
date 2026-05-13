<form action="{{ $action }}" method="POST">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

@if ($errors->any())
<div class="mb-4 p-4 bg-red-50 text-red-600 rounded">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="bg-white rounded-xl shadow p-6 mb-6">

    <h3 class="text-lg font-semibold mb-4">
        Data Kriteria dan Bobot <span class="text-orange-500">(Wajib)</span>
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div>
            <label class="block text-sm mb-1">Nama Kriteria</label>
            <input type="text" name="nama_kriteria"
                   class="w-full rounded-lg border-gray-300"
                   value="{{ old('nama_kriteria', $kriteria->nama_kriteria ?? '') }}"
                   required>
        </div>

        <div>
            <label class="block text-sm mb-1">Jenis Kriteria</label>
            <select name="jenis"
            class="w-full rounded-lg border-gray-300 focus:ring focus:ring-blue-200">

                <option value="" disabled selected hidden>Pilih</option>

                @foreach ($jenisKriterias as $jenis)

                <option value="{{ strtolower($jenis->nama_jenis_kriteria) }}"
                {{ old('jenis',$kriteria?->jenis)==strtolower($jenis->nama_jenis_kriteria)?'selected':'' }}>

                {{ $jenis->nama_jenis_kriteria }}

                </option>

            @endforeach

            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Bobot</label>
            <input type="number"
                name="bobot"
                id="bobot"
                step="any"
                min="0"
                max="1"
                class="w-full rounded-lg border-gray-300"
                value="{{ old('bobot', $kriteria->bobot ?? '') }}"
                required>
        </div>

    </div>

    <div class="mt-6">
        <label class="block text-sm mb-1">Deskripsi (Opsional)</label>
        <textarea name="deskripsi"
                  class="w-full rounded-lg border-gray-300"
                  rows="2">{{ old('deskripsi', $kriteria->deskripsi ?? '') }}</textarea>
    </div>

</div>


<div class="bg-white rounded-xl shadow p-6 mb-6">

    <h3 class="text-lg font-semibold mb-4">
        Kategori Kriteria <span class="text-gray-500">(Opsional)</span>
    </h3>

    <div id="kategori-wrapper">

    @php
    $kategoriCollection = isset($kriteria) ? $kriteria->subKriterias : collect();

    $kategoriNama = old('kategori.nama_kategori')
        ?? ($kategoriCollection->pluck('nama')->toArray() ?: ['']);

    $kategoriMin = old('kategori.min_value')
        ?? ($kategoriCollection->pluck('min_value')->toArray() ?: ['']);

    $kategoriMax = old('kategori.max_value')
        ?? ($kategoriCollection->pluck('max_value')->toArray() ?: ['']);

    $kategoriSatuan = old('kategori.satuan')
        ?? ($kategoriCollection->pluck('satuan')->toArray() ?: ['']);

    $kategoriNilai = old('kategori.nilai')
        ?? ($kategoriCollection->pluck('skor')->toArray() ?: ['']);
    @endphp

    @foreach($kategoriNama as $i => $val)
    
    <div class="kategori-item flex gap-3 items-center mb-4 w-full">

<input type="text"
name="kategori[nama_kategori][]"
class="w-[35%] rounded-xl border-gray-300 h-10 px-3 text-sm"
placeholder="Nama Kategori"
value="{{ $val }}">

<input type="number"
name="kategori[min_value][]"
class="w-[8%] rounded-xl border-gray-300 h-10 px-3 text-sm"
placeholder="Min"
value="{{ $kategoriMin[$i] ?? '' }}">

<input type="number"
name="kategori[max_value][]"
class="w-[10%] rounded-xl border-gray-300 h-10 px-3 text-sm"
placeholder="Max"
value="{{ $kategoriMax[$i] ?? '' }}">

<select name="kategori[satuan][]"
class="w-[10%] rounded-xl border-gray-300 h-10 px-3 text-sm">

<option value="" disabled selected hidden>Pilih</option>

@foreach ($satuans as $satuan)
<option value="{{ $satuan->simbol }}"
{{ ($kategoriSatuan[$i] ?? '') == $satuan->simbol ? 'selected' : '' }}>
{{ $satuan->nama_satuan }} ({{ $satuan->simbol }})
</option>
@endforeach

</select>

<input type="number"
name="kategori[nilai][]"
class="w-[10%] rounded-xl border-gray-300 h-10 px-3 text-sm"
placeholder="Nilai"
value="{{ $kategoriNilai[$i] ?? '' }}">

<button type="button"
class="btn-remove w-10 h-10 flex items-center justify-center
rounded-lg bg-red-600 text-white hover:bg-red-700">
×
</button>

</div>

@endforeach

    </div>

    <div class="mt-4">
        <button type="button"
        id="btn-tambah-kategori"
        class="px-4 py-2 
            bg-orange-100 
            text-orange-600 
            rounded-lg text-sm
            hover:bg-orange-200 transition">
        + Tambah Kategori Kriteria
    </button>
</div>
</div>

<div class="flex justify-end gap-3">
    <a href="{{ route('kriteria.index') }}"
       class="px-4 py-2 border rounded-lg text-gray-600">
        Batal
    </a>

    <button type="submit"
        class="px-5 py-2 bg-[color:var(--bpbd-blue)] text-white rounded-lg">
        {{ $submitText }}
    </button>
</div>

</form>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const wrapper = document.getElementById('kategori-wrapper');
    const btnTambah = document.getElementById('btn-tambah-kategori');
    const bobotInput = document.getElementById('bobot');

    /* ===============================
       1. HANDLE REMOVE BUTTON
    =============================== */
    function updateRemoveButtons() {
        const items = wrapper.querySelectorAll('.kategori-item');

        items.forEach((item) => {
            const btn = item.querySelector('.btn-remove');

            btn.style.visibility = (items.length === 1) ? 'hidden' : 'visible';

            btn.onclick = function () {
                item.remove();
                updateRemoveButtons();
            };
        });
    }

    btnTambah.addEventListener('click', function () {
        let firstItem = wrapper.querySelector('.kategori-item');
        let item = firstItem.cloneNode(true);

        item.querySelectorAll('input, select').forEach(el => el.value = '');

        wrapper.appendChild(item);

        updateRemoveButtons();
    });

    updateRemoveButtons();


    /* ===============================
       2. VALIDASI BOBOT
    =============================== */
    if (bobotInput) {

        bobotInput.addEventListener('input', function () {

            let value = this.value;

            // Auto convert 02 → 0.2
            if (/^0\d+/.test(value)) {
                let raw = value.replace(/^0/, '');
                this.value = '0.' + raw.substring(0, 2);
            }

            // Validasi > 1
            if (parseFloat(this.value) > 1) {
                this.setCustomValidity('Bobot tidak boleh lebih dari 1');
            } else {
                this.setCustomValidity('');
            }

            this.reportValidity();
        });
    }

});
</script>
