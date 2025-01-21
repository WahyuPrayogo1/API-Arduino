<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;  // Pastikan ini ada
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;  // Pastikan ini ada untuk Auth

class AuthController extends Controller
{
    // Fungsi login
    public function login(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah email dan password valid
        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);
        }

        // Login pengguna
        Auth::login($user);

        // Buat dan kirimkan token
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
        ]);
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        // Hapus token yang digunakan
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }
}
