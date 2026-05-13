<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SIRR-PASNA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bpbd-blue: #1e40af;
            --bpbd-orange: #f97316;
        }

        /* ================= FORM ALIGNMENT ONLY ================= */

        /* Input lebih clean tapi tetap font bawaan */
        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 8px 12px;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
        }

        /* Focus biru sesuai brand */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--bpbd-blue);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.12);
            outline: none;
        }

        /* Label lebih rapi tanpa ubah font */
        label {
            font-size: 0.85rem;
            color: #4b5563;
            margin-bottom: 6px;
        }

        /* Section title sedikit lebih tegas */
        h5 {
            font-weight: 600;
            color: #374151;
        }

        /* Divider lebih soft */
        hr {
            border-color: #e5e7eb;
            opacity: 1;
        }

        /* BUTTON STYLE */
        .btn-primary-custom {
            background-color: var(--bpbd-blue);
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 10px;
            transition: 0.2s;
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
        }

        .btn-outline-custom {
            border: 1px solid #d1d5db;
            background: white;
            padding: 8px 18px;
            border-radius: 10px;
            color: #4b5563;
            transition: 0.2s;
        }

        .btn-outline-custom:hover {
            background: #f3f4f6;
        }

        /* Error clean */
        .alert-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 12px 16px;
            border-radius: 12px;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">

<div x-data="{ 
    open: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true'),
    
    masterOpen: {{ request()->is('kecamatan*') 
    || request()->is('desa*') 
    || request()->is('jenis-bencana*') 
    || request()->is('master-proyek*')
    || request()->is('jenis-infrastruktur*') 
    || request()->is('satuan*') 
    || request()->is('kewenangan-aset*') 
    || request()->is('jenis-kriteria*') ? 'true' : 'false' }},

    masterActive: {{ request()->is('kecamatan*') 
    || request()->is('desa*') 
    || request()->is('jenis-bencana*') 
    || request()->is('master-proyek*')
    || request()->is('jenis-infrastruktur*') 
    || request()->is('satuan*') 
    || request()->is('kewenangan-aset*') 
    || request()->is('jenis-kriteria*') ? 'true' : 'false' }}
}" 
x-init="$watch('open', val => localStorage.setItem('sidebarOpen', val))"
class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside 
        x-cloak
        :class="open ? 'w-64' : 'w-20'"
        class="fixed top-0 left-0 h-screen
        bg-gradient-to-b from-orange-600 to-orange-700
        text-white shadow-md flex flex-col
        overflow-visible z-40
        transition-none"
    >
    
        <div 
            :class="open ? 'justify-between px-4' : 'justify-center px-0'"
            class="flex items-center h-16 border-b border-orange-500">

            {{-- LOGO --}}
            <span 
                x-show="open"
                x-transition.opacity.duration.200ms
                class="font-semibold">
                SIRR-PASNA
            </span>

            {{-- BUTTON --}}
            <button 
                @click="open = !open"
                class="text-white text-xl">
                ☰
            </button>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-2 py-4 space-y-2 text-sm">

        {{-- MENU SEMUA USER --}}
        <a href="{{ route('dashboard') }}"
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0',
            ({{ request()->routeIs('dashboard') ? 'true' : 'false' }} && !masterActive)
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">

            {{-- ICON FIX --}}
            <span class="w-5 h-5 flex items-center justify-center">

                <img src="{{ asset('icons/dashboard-outline.png') }}"
                class="w-5 h-5"
                :class="({{ request()->routeIs('dashboard') ? 'true' : 'false' }} && !masterActive) ? 'hidden' : 'block'">

                <img src="{{ asset('icons/dashboard-fill.png') }}"
                class="w-5 h-5"
                :class="({{ request()->routeIs('dashboard') ? 'true' : 'false' }} && !masterActive) ? 'block' : 'hidden'">
            </span>

            {{-- TEXT --}}
            <span 
                :class="open ? 'opacity-100 ml-0 w-auto' : 'opacity-0 w-0 ml-0 overflow-hidden'"
                class="transition-all duration-200 whitespace-nowrap">
                Dashboard
            </span>

        </a>

        <a href="{{ route('prioritas.index') }}"
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0',
            ({{ request()->routeIs('prioritas.index') ? 'true' : 'false' }} && !masterActive)
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">

        {{-- ICON FIX --}}
        <span class="w-5 h-5 flex items-center justify-center">

        <img src="{{ asset('icons/prioritas-outline.png') }}"
        class="w-5 h-5"
        :class="({{ request()->routeIs('prioritas.index') ? 'true' : 'false' }} && !masterActive) ? 'hidden' : 'block'">

        <img src="{{ asset('icons/prioritas-fill.png') }}"
        class="w-5 h-5"
        :class="({{ request()->routeIs('prioritas.index') ? 'true' : 'false' }} && !masterActive) ? 'block' : 'hidden'">

        </span>

            {{-- TEXT --}}
            <span 
                :class="open ? 'opacity-100 ml-0 w-auto' : 'opacity-0 w-0 ml-0 overflow-hidden'"
                class="transition-all duration-200 whitespace-nowrap">
                Daftar Prioritas Proyek
            </span>
        </a>

        <a href="{{ route('alternatif.index') }}"
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0',
            ({{ request()->routeIs('alternatif.*') ? 'true' : 'false' }} && !masterActive)
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">

            {{-- ICON FIX --}}
            <span class="w-5 h-5 flex items-center justify-center">

            <img src="{{ asset('icons/alternatif-outline.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('alternatif.*') ? 'true' : 'false' }} && !masterActive) ? 'hidden' : 'block'">

            <img src="{{ asset('icons/alternatif-fill.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('alternatif.*') ? 'true' : 'false' }} && !masterActive) ? 'block' : 'hidden'">

            </span>

            {{-- TEXT --}}
            <span 
                :class="open ? 'opacity-100 ml-0 w-auto' : 'opacity-0 w-0 ml-0 overflow-hidden'"
                class="transition-all duration-200 whitespace-nowrap">
                Data Kerusakan
            </span>
        </a>


        {{-- MENU KHUSUS SUPERADMIN --}}
        @if(strtolower(Auth::user()->role) == 'superadmin')

        <a href="{{ route('proyek.index') }}"
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0',
            ({{ request()->routeIs('proyek.*') ? 'true' : 'false' }} && !masterActive)
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            
            {{-- ICON FIX --}}
            <span class="w-5 h-5 flex items-center justify-center">

            <img src="{{ asset('icons/proyek-outline.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('proyek.*') ? 'true' : 'false' }} && !masterActive) ? 'hidden' : 'block'">

            <img src="{{ asset('icons/proyek-fill.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('proyek.*') ? 'true' : 'false' }} && !masterActive) ? 'block' : 'hidden'">

            </span>

            {{-- TEXT --}}
            <span 
                :class="open ? 'opacity-100 ml-0 w-auto' : 'opacity-0 w-0 ml-0 overflow-hidden'"
                class="transition-all duration-200 whitespace-nowrap">
                Manajemen Proyek
            </span>
        </a>

        <a href="{{ route('kriteria.index') }}"
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0',
            ({{ request()->routeIs('kriteria.*') ? 'true' : 'false' }} && !masterActive)
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            
            {{-- ICON FIX --}}
            <span class="w-5 h-5 flex items-center justify-center">

            <img src="{{ asset('icons/bobot-outline.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('kriteria.*') ? 'true' : 'false' }} && !masterActive) ? 'hidden' : 'block'">

            <img src="{{ asset('icons/bobot-fill.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('kriteria.*') ? 'true' : 'false' }} && !masterActive) ? 'block' : 'hidden'">

            </span>

            {{-- TEXT --}}
            <span 
                :class="open ? 'opacity-100 ml-0 w-auto' : 'opacity-0 w-0 ml-0 overflow-hidden'"
                class="transition-all duration-200 whitespace-nowrap">
                Kriteria dan Bobot
            </span>
        </a>

        <a href="{{ route('laporan.index') }}"
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0',
            ({{ request()->routeIs('laporan.*') ? 'true' : 'false' }} && !masterActive)
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            
            {{-- ICON FIX --}}
            <span class="w-5 h-5 flex items-center justify-center">

            <img src="{{ asset('icons/laporan-outline.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('laporan.*') ? 'true' : 'false' }} && !masterActive) ? 'hidden' : 'block'">

            <img src="{{ asset('icons/laporan-fill.png') }}"
            class="w-5 h-5"
            :class="({{ request()->routeIs('laporan.*') ? 'true' : 'false' }} && !masterActive) ? 'block' : 'hidden'">

            </span>

            {{-- TEXT --}}
            <span 
                :class="open ? 'opacity-100 ml-0 w-auto' : 'opacity-0 w-0 ml-0 overflow-hidden'"
                class="transition-all duration-200 whitespace-nowrap">
                Laporan
            </span>
        </a>

        <a href="{{ route('users.index') }}"
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0',
            ({{ request()->routeIs('users.*') ? 'true' : 'false' }} && !masterActive)
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
                    
            {{-- ICON FIX --}}
            <span class="w-5 h-5 flex items-center justify-center">

                <img src="{{ asset('icons/user-outline.png') }}" 
                class="w-5 h-5 transition-opacity duration-200"
                :class="[
                    ({{ request()->routeIs('users.*') ? 'true' : 'false' }} && !masterActive)
                        ? 'opacity-0 hidden'
                        : 'opacity-100'
                ]">

                <img src="{{ asset('icons/user-fill.png') }}" 
                class="w-5 h-5 transition-opacity duration-200"
                :class="[
                    ({{ request()->routeIs('users.*') ? 'true' : 'false' }} && !masterActive)
                        ? 'opacity-100'
                        : 'opacity-0 hidden'
                ]">

            </span>

            {{-- TEXT --}}
            <span 
                :class="open ? 'opacity-100 ml-0 w-auto' : 'opacity-0 w-0 ml-0 overflow-hidden'"
                class="transition-all duration-200 whitespace-nowrap">
                Manajemen User
            </span>
        </a>

        {{-- DATA MASTER DROPDOWN --}}
        <div>

        <button 
        @click="
            masterOpen = !masterOpen;
            masterActive = true;
        "
        class="flex items-center py-2 rounded-lg transition-all duration-200"
        :class="[
            open ? 'gap-3 px-3 justify-start' : 'justify-center px-0 w-full',

            masterActive
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">

            {{-- ICON --}}
            <span class="w-5 h-5 flex items-center justify-center">

            <img src="{{ asset('icons/master-outline.png') }}" 
            :class="masterActive ? 'hidden' : 'block'"
                {{ request()->is('kecamatan*') 
                || request()->is('desa*') 
                || request()->is('jenis-kriteria*') 
                || request()->is('satuan*') 
                ? 'opacity-0 hidden' : 'opacity-100' }}">

            <img src="{{ asset('icons/master-fill.png') }}" 
            :class="masterActive ? 'block' : 'hidden'"
                {{ request()->is('kecamatan*') 
                || request()->is('desa*') 
                || request()->is('jenis-kriteria*') 
                || request()->is('satuan*') 
                ? 'opacity-100' : 'opacity-0 hidden' }}">

        </span>

            {{-- TEXT --}}
            <span 
                x-show="open"
                class="whitespace-nowrap">
                Data Master
            </span>

            {{-- ARROW --}}
            <svg 
                x-show="open"
                class="w-4 h-4 ml-auto transform transition"
                :class="{ 'rotate-180': masterOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7"/>
            </svg>

        </button>

        {{-- DROPDOWN LIST --}}
        <div x-show="open && masterOpen"
            x-transition
            class="mt-2 space-y-1 pl-6">
        
        <a href="{{ route('jenis-bencana.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200"
        :class="[
            {{ request()->is('jenis-bencana*') ? 'true' : 'false' }}
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            Jenis Bencana
        </a>

        <a href="{{ route('master-proyek.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200"
        :class="[
            {{ request()->is('master-proyek*') ? 'true' : 'false' }}
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            Jenis Proyek
        </a>

        {{-- <a href="{{ route('jenis-infrastruktur.index') }}"
        class="block px-3 py-2 rounded hover:bg-gray-100
        {{ request()->is('jenis-infrastruktur*') ? 'bg-orange-100 text-orange-600' : '' }}">
        Jenis Infrastruktur
        </a> --}}

        <a href="{{ route('kecamatan.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200"
        :class="[
            {{ request()->is('kecamatan*') ? 'true' : 'false' }}
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            Kecamatan
        </a>

        <a href="{{ route('desa.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200"
        :class="[
            {{ request()->is('desa*') ? 'true' : 'false' }}
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            Desa/Kelurahan
        </a>

        {{-- <a href="{{ route('kewenangan-aset.index') }}"
        class="block px-3 py-2 rounded hover:bg-gray-100
        {{ request()->is('kewenangan-aset*') ? 'bg-orange-100 text-orange-600' : '' }}">
        Kewenangan Aset
        </a> --}}

        <a href="{{ route('jenis-kriteria.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200"
        :class="[
            {{ request()->routeIs('jenis-kriteria.*') ? 'true' : 'false' }}
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            Jenis Kriteria
        </a>

        <a href="{{ route('satuan.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200"
        :class="[
            {{ request()->is('satuan*') ? 'true' : 'false' }}
                ? 'bg-orange-800 text-white font-semibold'
                : 'text-white/80 hover:text-white hover:bg-orange-800'
        ]">
            Satuan
        </a>

        </div>

        </div>

        @endif

        </nav>
    </aside>

    {{-- CONTENT --}}
    <div 
        :class="open ? 'ml-64' : 'ml-20'"
        class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out"
    >
        
    {{-- TOPBAR --}}
    <header class="sticky top-0 z-50 bg-white shadow-sm h-16 flex items-center justify-between px-6">
        
        <h1 class="text-lg font-semibold text-gray-700">
            @yield('title')
        </h1>

    {{-- DROPDOWN ACCOUNT --}}
    <div x-data="{ open: false }" class="relative">
        
        {{-- BUTTON --}}
        <button 
            @click="open = !open"
            class="flex items-center gap-3 hover:bg-gray-100 px-3 py-2 rounded-xl transition"
        >

            {{-- FOTO PROFILE --}}
            <div class="w-9 h-9 rounded-full overflow-hidden border border-gray-200 shadow-sm">

                @if(Auth::user()->photo)
                    <img 
                        src="{{ asset('storage/' . Auth::user()->photo) }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-orange-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

            </div>

            {{-- USER INFO --}}
            <div class="hidden md:flex flex-col items-start leading-tight">
                <span class="text-sm font-semibold text-gray-700">
                    {{ Auth::user()->name }}
                </span>

                <span class="text-xs text-gray-400">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>

            {{-- ARROW --}}
            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"/>
    </svg>

</button>

        {{-- DROPDOWN MENU --}}
        <div 
            x-show="open"
            @click.away="open = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50"
        >

            {{-- PROFILE --}}
            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition">
                Profile
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                    Logout
                </button>
            </form>

        </div>
        </div>
    </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>

</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

</body>
</html>
