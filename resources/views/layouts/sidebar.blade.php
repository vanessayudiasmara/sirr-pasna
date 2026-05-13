<div class="h-16 border-b border-orange-500 flex items-center relative">

    {{-- BUTTON --}}
    <button 
        @click="open = !open"
        class="text-white text-xl z-50"
        :class="open ? 'ml-4' : 'mx-auto'">
        ☰
    </button>

    {{-- LOGO --}}
    <span 
        :class="open ? 'opacity-100 ml-4' : 'opacity-0'"
        class="transition-all duration-200 font-bold whitespace-nowrap absolute left-10">
        SIRR-PASNA
    </span>

</div>

    <nav class="flex-1 p-4 space-y-2 text-sm">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
        {{ request()->routeIs('dashboard') 
                ? 'bg-white text-orange-600 font-semibold' 
                : 'text-white/80 hover:bg-orange-700 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>

        {{-- PRIORITAS --}}
        <a href="{{ route('prioritas.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
        {{ request()->routeIs('prioritas.index') 
                ? 'bg-white text-orange-600 font-semibold' 
                : 'text-white/80 hover:bg-orange-700 hover:text-white' }}">
            <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
            <span>Data Prioritas</span>
        </a>


        {{-- DATA KERUSAKAN (SEMUA ROLE) --}}
        <a href="{{ route('alternatif.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
        {{ request()->routeIs('alternatif.*') 
                ? 'bg-white text-orange-600 font-semibold' 
                : 'text-white/80 hover:bg-orange-700 hover:text-white' }}">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>Data Kerusakan</span>
        </a>


        {{-- SUPERADMIN ONLY --}}
        @if(auth()->user()->role == 'superadmin')

            {{-- PROYEK --}}
            <a href="{{ route('proyek.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('proyek.*') 
                    ? 'bg-white text-orange-600 font-semibold' 
                    : 'text-white/80 hover:bg-orange-700 hover:text-white' }}">
                <i data-lucide="building-2" class="w-5 h-5"></i>
                <span>Manajemen Proyek</span>
            </a>

            {{-- KRITERIA --}}
            <a href="{{ route('kriteria.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('kriteria.*') 
                    ? 'bg-white text-orange-600 font-semibold' 
                    : 'text-white/80 hover:bg-orange-700 hover:text-white' }}">
                <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
                <span>Kriteria & Bobot</span>
            </a>

            {{-- LAPORAN --}}
            <a href="{{ route('laporan.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('laporan.*') 
                    ? 'bg-white text-orange-600 font-semibold' 
                    : 'text-white/80 hover:bg-orange-700 hover:text-white' }}">
                <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                <span>Laporan</span>
            </a>

            {{-- USER --}}
            <a href="{{ route('users.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg transition
            {{ request()->routeIs('users.*') 
                    ? 'bg-white text-orange-600 font-semibold' 
                    : 'text-white/80 hover:bg-orange-700 hover:text-white' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span>Manajemen User</span>
            </a>

        @endif

    </nav>
</aside>