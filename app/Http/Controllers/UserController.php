<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

    $request->validate([
        'name' => 'required',
        'username' => 'required|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'role' => 'required',
        'status' => 'required'
    ],[
        'email.email' => 'Format email tidak valid',
        'password.confirmed' => 'Konfirmasi password tidak sama',
    ]);

    User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'jabatan' => $request->jabatan,
        'role' => $request->role,
        'status' => $request->status,
        'password' => Hash::make($request->password), 
    ]);

    return redirect()->route('users.index')
    ->with('success','User berhasil dibuat');

    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            'status' => 'required',
        ]);

        // update data utama
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        $user->role = $request->role;
        $user->status = $request->status;

        // password hanya diubah jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // proteksi supaya superadmin tidak bisa dihapus
        if ($user->role === 'superadmin') {
            return redirect()->route('users.index')
                ->with('error', 'SuperAdmin tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}