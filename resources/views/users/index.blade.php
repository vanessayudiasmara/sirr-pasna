@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

<div class="space-y-5">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Manajemen User
            </h2>

            <p class="text-gray-500 text-sm">
                Kelola data pengguna dan hak akses sistem
            </p>
        </div>

        <a href="{{ route('users.create') }}"
        class="bg-[color:var(--bpbd-blue)] text-white px-4 py-2 rounded-lg text-sm hover:opacity-90 transition">
            + Tambah User
        </a>

    </div>


    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl overflow-hidden border border-gray-100">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b">

                <tr class="text-center text-gray-600">

                    <th class="px-5 py-3 font-semibold w-16">
                        No
                    </th>

                    <th class="px-5 py-3 font-semibold">
                        Nama
                    </th>

                    <th class="px-5 py-3 font-semibold">
                        Email
                    </th>

                    <th class="px-5 py-3 font-semibold text-center">
                        Role
                    </th>

                    <th class="px-5 py-3 font-semibold text-center">
                        Status
                    </th>

                    <th class="px-5 py-3 font-semibold text-center w-40">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($users as $i => $user)

                <tr class="border-b hover:bg-orange-50/40 transition">

                    <td class="px-5 py-3 text-gray-700 text-center">
                        {{ $users->firstItem() + $i }}
                    </td>

                    <td class="px-5 py-3 font-medium text-gray-700 text-center">
                        {{ $user->name }}
                    </td>

                    <td class="px-5 py-3 text-gray-700 text-center">
                        {{ $user->email }}
                    </td>

                    <td class="px-5 py-3 text-center">

                        @if($user->role == 'superadmin')
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs">
                                SuperAdmin
                            </span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                User
                            </span>
                        @endif

                    </td>

                    <td class="px-5 py-3 text-center">

                        @if($user->status == 'aktif')
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs">
                                Nonaktif
                            </span>
                        @endif

                    </td>

                    <td class="px-5 py-3">

                        <div class="flex justify-center gap-2">

                            {{-- EDIT --}}
                            <a href="{{ route('users.edit', $user->id) }}"
                            class="px-3 py-1 text-xs font-medium rounded-md 
                                    bg-orange-500 text-white 
                                    hover:bg-orange-600 transition">
                                Edit
                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    onclick="return confirm('Yakin hapus user ini?')"
                                    class="px-3 py-1 text-xs font-medium rounded-md 
                                    border border-red-300 text-red-600 bg-red-50 
                                    hover:bg-red-100 transition">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6"
                    class="px-5 py-8 text-center text-gray-400">
                        Data user belum tersedia
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>


        {{-- PAGINATION --}}
        <div class="flex justify-between items-center px-5 py-3 bg-white">

            <div class="text-sm text-gray-500">
                Showing {{ $users->firstItem() }}
                to {{ $users->lastItem() }}
                of {{ $users->total() }} results
            </div>

            <div>
                {{ $users->onEachSide(1)->links() }}
            </div>

        </div>

    </div>

</div>

@endsection