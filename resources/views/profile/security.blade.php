@extends('layouts.app')

@section('title', 'Keamanan Akun')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Keamanan Akun
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Kelola password akun Anda
        </p>
    </div>

    @if(session('status') === 'password-updated')

        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

            Password berhasil diperbarui

        </div>

    @endif


    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">

        <div class="grid lg:grid-cols-12 items-stretch">

            {{-- SIDEBAR --}}
            <div class="lg:col-span-4 border-r border-gray-100 bg-gray-50/40 p-8 flex">

                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden w-full">

                    <div class="p-8 flex flex-col items-center text-center">

                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-orange-100 shadow-sm">
                        @else
                            <div class="w-32 h-32 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-5xl font-bold border-4 border-orange-50">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                        @endif

                        <h3 class="mt-5 text-2xl font-bold text-gray-800">
                            {{ $user->name }}
                        </h3>

                        <p class="text-gray-500 mt-1">
                            {{ ucfirst($user->role) }}
                        </p>

                    </div>


                    {{-- MENU --}}
                    <div class="mt-8 space-y-3 w-full px-2">

                        <a href="{{ route('profile.edit') }}"
                        class="block w-full text-gray-500 hover:bg-gray-100 rounded-2xl px-5 py-3 text-sm transition">
                            Personal Information
                        </a>

                        <a href="{{ route('profile.security') }}"
                        class="block w-full bg-orange-100 text-orange-700 rounded-2xl px-5 py-3 font-medium text-sm">
                            Login & Password
                        </a>

                    </div>

                </div>

            </div>



            {{-- CONTENT --}}
            <div class="lg:col-span-8 p-8">

                <div class="bg-white rounded-[28px] border border-gray-100 overflow-hidden">

                    <div class="px-8 py-5 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-gray-800">
                            Login & Password
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Perbarui password akun Anda secara berkala
                        </p>
                    </div>

                    <div class="px-8 pt-5 pb-8">

                        {{-- SUCCESS --}}
                        @if(session('status') === 'password-updated')

                            <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                                Password berhasil diperbarui
                            </div>

                        @endif


                        {{-- ERROR --}}
                        @if ($errors->any())

                            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                                <ul class="space-y-1">

                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach

                                </ul>

                            </div>

                        @endif

                        <form method="POST"
                            action="{{ route('password.update') }}"
                            class="space-y-5">

                            @csrf
                            @method('PUT')

                            {{-- PASSWORD LAMA --}}
                            <div>

                                <label class="text-sm text-gray-600 font-medium">
                                    Password Lama
                                </label>

                                <div x-data="{ show: false }" class="relative mt-3">

                                    <input
                                        :type="show ? 'text' : 'password'"
                                        name="current_password"
                                        class="w-full rounded-2xl border-gray-200 bg-gray-50 px-5 py-3.5 pr-14 text-sm">

                                    <button
                                        type="button"
                                        @click="show = !show"
                                        class="absolute right-4 top-1/2 -translate-y-1/2">

                                        <img
                                            x-show="!show"
                                            src="{{ asset('icons/eye-close.png') }}"
                                            class="w-5 h-5 opacity-60 hover:opacity-100 transition">

                                        <img
                                            x-show="show"
                                            src="{{ asset('icons/eye-open.png') }}"
                                            class="w-5 h-5 opacity-60 hover:opacity-100 transition">

                                    </button>

                                </div>

                            </div>


                            {{-- PASSWORD BARU --}}
                            <div>

                                <label class="text-sm text-gray-600 font-medium">
                                    Password Baru
                                </label>

                                <div x-data="{ show: false }" class="relative mt-3">

                                    <input
                                        :type="show ? 'text' : 'password'"
                                        name="password"
                                        class="w-full rounded-2xl border-gray-200 bg-gray-50 px-5 py-3.5 pr-14 text-sm">

                                    <button
                                        type="button"
                                        @click="show = !show"
                                        class="absolute right-4 top-1/2 -translate-y-1/2">

                                        <img
                                            x-show="!show"
                                            src="{{ asset('icons/eye-close.png') }}"
                                            class="w-5 h-5 opacity-60 hover:opacity-100 transition">

                                        <img
                                            x-show="show"
                                            src="{{ asset('icons/eye-open.png') }}"
                                            class="w-5 h-5 opacity-60 hover:opacity-100 transition">

                                    </button>

                                </div>

                            </div>


                            {{-- KONFIRMASI PASSWORD --}}
                            <div>

                                <label class="text-sm text-gray-600 font-medium">
                                    Konfirmasi Password
                                </label>

                                <div x-data="{ show: false }" class="relative mt-3">

                                    <input
                                        :type="show ? 'text' : 'password'"
                                        name="password_confirmation"
                                        class="w-full rounded-2xl border-gray-200 bg-gray-50 px-5 py-3.5 pr-14 text-sm">

                                    <button
                                        type="button"
                                        @click="show = !show"
                                        class="absolute right-4 top-1/2 -translate-y-1/2">

                                        <img
                                            x-show="!show"
                                            src="{{ asset('icons/eye-close.png') }}"
                                            class="w-5 h-5 opacity-60 hover:opacity-100 transition">

                                        <img
                                            x-show="show"
                                            src="{{ asset('icons/eye-open.png') }}"
                                            class="w-5 h-5 opacity-60 hover:opacity-100 transition">

                                    </button>

                                </div>

                            </div>


                            {{-- BUTTON --}}
                            <div class="flex justify-end gap-3 pt-2">

                                <a href="{{ route('profile.security') }}"
                                class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition font-medium text-sm">
                                    Batal
                                </a>

                                <button
                                class="bg-[color:var(--bpbd-orange)] hover:opacity-90 transition text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm">
                                    Update Password
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection