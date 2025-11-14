<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:admins,email',
            'password' => 'required|string'
        ]);

        $admin = Admin::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        $token = $admin->createToken('admin-token-register')->plainTextToken;

        return response()->json([
            'message' => 'Register success',
            'admin' => $admin,
            'token' => $token
        ], 201);
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek admin berdasarkan email
        $admin = Admin::where('email', $request->email)->first();

        // Cek password
        if (!$admin || !Hash::check($request->password, $admin->password)) {
             return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Buat token baru
        $token = $admin->createToken('admin-token-login')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'admin' => $admin,
            'token' => $token
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
