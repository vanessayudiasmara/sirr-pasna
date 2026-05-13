@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

<div class="space-y-6">

    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Tambah Akun Baru
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tambahkan akun pengguna baru ke dalam sistem
        </p>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
            <ul class="text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                {{-- NAMA --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama
                    </label>

                    <input type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama"
                        class="w-full rounded-2xl border-gray-200 bg-gray-50
                               px-4 py-3 text-sm focus:border-orange-500
                               focus:ring-orange-500">
                </div>

                {{-- USERNAME --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>

                    <input type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        class="w-full rounded-2xl border-gray-200 bg-gray-50
                               px-4 py-3 text-sm focus:border-orange-500
                               focus:ring-orange-500">
                </div>

                {{-- PASSWORD --}}
                <div x-data="{ show:false }">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <div class="relative">

                        <input
                            :type="show ? 'text' : 'password'"
                            name="password"
                            placeholder="Masukkan password"
                            class="w-full rounded-2xl border-gray-200 bg-gray-50
                                   px-4 py-3 pr-12 text-sm">

                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute right-4 top-3.5">

                            <img x-show="!show"
                                src="{{ asset('icons/eye-close.png') }}"
                                class="w-5 h-5 opacity-60">

                            <img x-show="show"
                                src="{{ asset('icons/eye-open.png') }}"
                                class="w-5 h-5 opacity-60">

                        </button>

                    </div>

                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        class="w-full rounded-2xl border-gray-200 bg-gray-50
                               px-4 py-3 text-sm">
                </div>

                {{-- JABATAN --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jabatan / Unit Kerja
                    </label>

                    <input type="text"
                        name="jabatan"
                        value="{{ old('jabatan') }}"
                        placeholder="Masukkan jabatan"
                        class="w-full rounded-2xl border-gray-200 bg-gray-50
                               px-4 py-3 text-sm">
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div x-data="{ showConfirm:false }">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>

                    <div class="relative">

                        <input
                            :type="showConfirm ? 'text' : 'password'"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            class="w-full rounded-2xl border-gray-200 bg-gray-50
                                   px-4 py-3 pr-12 text-sm">

                        <button
                            type="button"
                            @click="showConfirm = !showConfirm"
                            class="absolute right-4 top-3.5">

                            <img x-show="!showConfirm"
                                src="{{ asset('icons/eye-close.png') }}"
                                class="w-5 h-5 opacity-60">

                            <img x-show="showConfirm"
                                src="{{ asset('icons/eye-open.png') }}"
                                class="w-5 h-5 opacity-60">

                        </button>

                    </div>

                </div>

                {{-- ROLE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hak Akses
                    </label>

                    <select name="role"
                        class="w-full rounded-2xl border-gray-200 bg-gray-50
                               px-4 py-3 text-sm">

                        <option value="superadmin">SuperAdmin</option>
                        <option value="user">User</option>

                    </select>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Akun
                    </label>

                    <select name="status"
                        class="w-full rounded-2xl border-gray-200 bg-gray-50
                               px-4 py-3 text-sm">

                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>

                    </select>
                </div>

                {{-- TANGGAL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Dibuat
                    </label>

                    <input type="text"
                        value="{{ now()->format('d/m/Y') }}"
                        disabled
                        class="w-full rounded-2xl border-gray-200 bg-gray-100
                               px-4 py-3 text-sm text-gray-500">
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('users.index') }}"
                    class="px-5 py-3 rounded-2xl border border-gray-200
                           text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>

                <button type="submit"
                    class="px-5 py-3 rounded-2xl bg-[color:var(--bpbd-blue)]
                           text-white hover:opacity-90 transition">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection