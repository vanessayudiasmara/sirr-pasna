@extends('layouts.app')

@section('title','Tambah Proyek')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Tambah Jenis Proyek
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tambahkan data jenis proyek baru
        </p>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">

        <form method="POST"
              action="{{ route('master-proyek.store') }}">
            @csrf

            <div class="p-8">

                <div>
                    <label class="text-sm font-medium text-gray-600">
                        Nama Proyek
                    </label>

                    <input type="text"
                        name="nama_proyek"
                        value="{{ old('nama_proyek') }}"
                        placeholder="Masukkan nama proyek"
                        class="w-full mt-3 rounded-2xl border-gray-200
                               bg-gray-50 px-5 py-3.5 text-sm
                               focus:border-orange-400
                               focus:ring-orange-400">

                    @error('nama_proyek')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="border-t border-gray-100 px-8 py-5 flex justify-end gap-3">

                <a href="{{ route('master-proyek.index') }}"
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