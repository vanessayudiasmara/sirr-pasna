@extends('layouts.app')

@section('title','Tambah Desa')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Tambah Data Desa
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tambahkan data desa atau kelurahan baru
        </p>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">

        <form method="POST"
              action="{{ route('desa.store') }}">
            @csrf

            <div class="p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- KECAMATAN --}}
                    <div>

                        <label class="text-sm font-medium text-gray-600">
                            Kecamatan
                        </label>

                        <select name="kecamatan_id"
                            class="w-full mt-3 rounded-2xl border-gray-200
                                   bg-gray-50 px-5 py-3.5 text-sm
                                   focus:border-orange-400
                                   focus:ring-orange-400">

                            <option value="" disabled selected hidden>
                                Pilih Kecamatan
                            </option>

                            @foreach($kecamatans as $kecamatan)

                                <option value="{{ $kecamatan->id }}"
                                    {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>

                                    {{ $kecamatan->nama_kecamatan }}

                                </option>

                            @endforeach

                        </select>

                        @error('kecamatan_id')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- DESA --}}
                    <div>

                        <label class="text-sm font-medium text-gray-600">
                            Nama Desa / Kelurahan
                        </label>

                        <input type="text"
                            name="nama_desa"
                            value="{{ old('nama_desa') }}"
                            placeholder="Masukkan nama desa / kelurahan"
                            class="w-full mt-3 rounded-2xl border-gray-200
                                   bg-gray-50 px-5 py-3.5 text-sm
                                   focus:border-orange-400
                                   focus:ring-orange-400">

                        @error('nama_desa')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="border-t border-gray-100 px-8 py-5 flex justify-end gap-3">

                <a href="{{ route('desa.index') }}"
                    class="px-5 py-2.5 rounded-2xl border border-gray-200
                           text-gray-600 text-sm font-medium
                           hover:bg-gray-50 transition">
                    Batal
                </a>

                <button type="submit"
                    class="bg-[color:var(--bpbd-orange)]
                           hover:opacity-90 transition
                           text-white px-5 py-2.5
                           rounded-2xl text-sm font-semibold shadow-sm">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection