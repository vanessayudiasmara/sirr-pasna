@extends('layouts.app')

@section('title','Edit Jenis Kriteria')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Edit Jenis Kriteria
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Perbarui data jenis kriteria
        </p>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">

        <form method="POST"
              action="{{ route('jenis-kriteria.update',$jenis_kriteria) }}">
            @csrf
            @method('PUT')

            <div class="p-8">

                <div>

                    <label class="text-sm font-medium text-gray-600">
                        Nama Jenis Kriteria
                    </label>

                    <input type="text"
                        name="nama_jenis_kriteria"
                        value="{{ old('nama_jenis_kriteria', $jenis_kriteria->nama_jenis_kriteria) }}"
                        placeholder="Contoh: Benefit"
                        class="w-full mt-3 rounded-2xl border-gray-200
                               bg-gray-50 px-5 py-3.5 text-sm
                               focus:border-orange-400
                               focus:ring-orange-400">

                    @error('nama_jenis_kriteria')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="border-t border-gray-100 px-8 py-5 flex justify-end gap-3">

                <a href="{{ route('jenis-kriteria.index') }}"
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
                    Update
                </button>

            </div>

        </form>

    </div>

</div>

@endsection