@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Profile Pengguna
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Kelola informasi akun Anda
        </p>
    </div>

    @if(session('status') === 'profile-updated')

        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

            Profil berhasil diperbarui

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
                        class="block w-full bg-orange-100 text-orange-700 rounded-2xl px-5 py-3 font-medium text-sm">
                            Personal Information
                        </a>

                        <a href="{{ route('profile.security') }}"
                        class="block w-full text-gray-500 hover:bg-gray-100 rounded-2xl px-5 py-3 text-sm transition">
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
                            Personal Information
                        </h3>
                    </div>


                    <div class="px-8 pt-5 pb-8">

                        <form method="POST"
                            action="{{ route('profile.update') }}"
                            enctype="multipart/form-data"
                            class="space-y-2">

                            @csrf
                            @method('PATCH')

                            {{-- PHOTO --}}
                            <div x-data="{ 
                                preview: '{{ $user->photo ? asset('storage/'.$user->photo) : '' }}',
                                open:false
                            }">

                                <label class="text-sm text-gray-600 font-medium">
                                    Foto Profile
                                </label>

                                <div class="flex items-center gap-5 mt-4">

                                    <template x-if="preview">
                                        <img 
                                            :src="preview"
                                            @click="open = true"
                                            class="w-28 h-28 rounded-full object-cover border-4 border-orange-100 shadow-sm cursor-pointer hover:scale-105 transition">
                                    </template>

                                    <div class="flex-1">

                                        <input type="file"
                                            name="photo"
                                            accept="image/*"
                                            @change="preview = URL.createObjectURL($event.target.files[0])"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                            file:mr-4 file:py-2.5 file:px-5
                                            file:rounded-xl file:border-0
                                            file:bg-orange-100 file:text-orange-700">

                                        <p class="text-xs text-gray-400 mt-3">
                                            JPG, JPEG, PNG maksimal 2MB
                                        </p>

                                    </div>

                                </div>


                                {{-- MODAL --}}
                                <div
                                    x-show="open"
                                    x-transition
                                    class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-6"
                                    style="display:none">

                                    <div class="relative">

                                        <button
                                            type="button"
                                            @click="open = false"
                                            class="absolute -top-3 -right-3 bg-white rounded-full w-9 h-9 text-black shadow-lg">
                                            ✕
                                        </button>

                                        <img
                                            :src="preview"
                                            class="max-w-[90vw] max-h-[90vh] rounded-3xl shadow-2xl object-contain">

                                    </div>

                                </div>

                            </div>



                            <div class="grid md:grid-cols-2 gap-6">

                                <div>
                                    <label class="text-sm text-gray-600 font-medium">
                                        Nama
                                    </label>

                                    <input type="text"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full mt-3 rounded-2xl border-gray-200 bg-gray-50 px-5 py-3.5 text-sm">
                                </div>


                                <div>
                                    <label class="text-sm text-gray-600 font-medium">
                                        Username
                                    </label>

                                    <input type="text"
                                        name="username"
                                        value="{{ old('username', $user->username) }}"
                                        class="w-full mt-3 rounded-2xl border-gray-200 bg-gray-50 px-5 py-3.5 text-sm">
                                </div>

                            </div>


                            <div>
                                <label class="text-sm text-gray-600 font-medium">
                                    Email
                                </label>

                                <input type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full mt-3 rounded-2xl border-gray-200 bg-gray-50 px-5 py-3.5 text-sm">
                            </div>


                            <div class="flex justify-end gap-3 pt-3">

                                <a href="{{ route('profile.edit') }}"
                                class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition font-medium">
                                    Batal
                                </a>

                                <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-xl font-medium transition">
                                    Simpan Perubahan
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