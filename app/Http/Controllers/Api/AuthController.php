<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // =========================
    // REGISTER
    // =========================

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user,
        ], 201);
    }


    // =========================
    // LOGIN
    // =========================

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (
            !$user ||
            !password_verify($credentials['password'], $user->password)
        ) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
        ]);
    }


    // =========================
    // LOGOUT
    // =========================

    public function logout(Request $request)
    {
        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }


    // =========================
    // USER LOGIN
    // =========================

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}