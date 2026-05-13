<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - SIRR-PASNA</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white-100">

<div class="min-h-screen flex">

    {{-- LEFT (IMAGE) --}}
    <div class="w-1/2 flex items-center justify-center bg-gray-200">
        <img src="{{ asset('images/bpbd2.png') }}"
             class="w-full h-full object-cover">
    </div>

    {{-- RIGHT (LOGIN) --}}
    <div class="w-1/2 flex flex-col justify-between items-center p-12">

        {{-- HEADER --}}
        <div class="w-full flex items-center justify-end gap-4 text-right">
    
            <div>
                <h1 class="text-xl font-bold">SIRR-PASNA</h1>
                <p class="text-sm text-gray-500">
                    Sistem Informasi Rehabilitasi Rekonstruksi Pascabencana
                </p>
            </div>

            <img src="{{ asset('images/BPBD-LOGO.png') }}"
                class="w-12 h-12 object-contain">

        </div>

        {{-- FORM --}}

        <div class="max-w-md mx-auto w-full bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-3xl font-bold mb-6">Log in</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label>Email atau Username</label>
                    <input type="text" name="login"
                    placeholder="Masukkan Email atau Username"
                    class="w-full mt-1 px-4 py-2 border rounded-lg bg-white
                    @error('login') border-red-500 @else border-gray-300 @enderror
                    focus:outline-none focus:ring-2 focus:ring-[color:var(--bpbd-blue)]">

                    @error('login')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4" x-data="{ show: false }">
                    <label>Kata Sandi</label>

                    <div class="relative mt-1">

                        <input 
                            :type="show ? 'text' : 'password'"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            class="w-full px-4 py-2 pr-10 border rounded-lg bg-white
                            @error('password') border-red-500 @else border-gray-300 @enderror
                            focus:outline-none focus:ring-2 focus:ring-[color:var(--bpbd-blue)]">

                        <button type="button"
                            @click="show = !show"
                            class="absolute right-3 top-2.5 text-gray-500">

                            {{-- EYE OPEN --}}
                            <img x-show="!show"
                                src="{{ asset('icons/eye-close.png') }}"
                                class="w-5 h-5">

                            {{-- EYE CLOSE --}}
                            <img x-show="show"
                                src="{{ asset('icons/eye-open.png') }}"
                                class="w-5 h-5">

                        </button>

                    </div>

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    class="w-full bg-[color:var(--bpbd-orange)] text-white py-2 rounded-lg
                        hover:bg-orange-600 transition duration-200 font-semibold">
                    Log in
                </button>

                <p class="text-xs text-gray-500 mt-3">
                    Lupa kata sandi? Hubungi admin BPBD.
                </p>
            </form>
        </div>

        {{-- FOOTER --}}
        <p class="text-xs text-gray-500 text-right w-full">
            © 2026 BPBD Kabupaten Ponorogo — All Rights Reserved
        </p>
    </div>

</div>

</div>

<script src="//unpkg.com/alpinejs" defer></script>

</body>
</html>