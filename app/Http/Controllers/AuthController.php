<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
            ]);
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            return response()->json([
                'message' => 'User registered successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    
    }

    // Login a user and return the token
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return response()->json([
                'message' => 'User logged in successfully',
                'data'=>[
                    'token' => $user->createToken($user->email)->plainTextToken,
                    'users'=> $user
                ]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

