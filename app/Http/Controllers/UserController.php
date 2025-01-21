<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('backend.pages.users.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('backend.pages.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rfid' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rfid' => $request->rfid,
        ]);

        $user->assignRole('User');

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit user
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('backend.pages.users.edit', compact('user', 'roles'));
    }

    // Mengupdate data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'rfid' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'rfid' => $request->rfid,
        ]);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    // Menghapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
