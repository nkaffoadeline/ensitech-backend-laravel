<?php

// app/Http/Controllers/Auth/LoginController.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // This is where Laravel validates the incoming request
        $request->validate([
            'username' => 'required|string', // Or 'email' => 'required|email'
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password'); // Or 'email'

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Assuming you are using Sanctum for API token or session
            // For session-based authentication:
            $request->session()->regenerate();
            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $user->createToken('auth_token')->plainTextToken]);
            // For Sanctum API Token based:
            // return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $user->createToken('auth_token')->plainTextToken]);

        }

        // If authentication fails, Laravel will often throw a ValidationException
        // This is what typically causes a 422 if not handled by a specific exception handler
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')], // Or 'email' => ...
        ]);
    }
}