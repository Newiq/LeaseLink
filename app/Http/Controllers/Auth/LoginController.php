<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::info('Login attempt', $request->all());

        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                Log::info('User not found', ['email' => $credentials['email']]);
                return response()->json([
                    'message' => 'User not found'
                ], 401);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                Log::info('Invalid password', ['email' => $credentials['email']]);
                return response()->json([
                    'message' => 'Invalid password'
                ], 401);
            }

            try {
                $token = $user->createToken('auth_token')->plainTextToken;
                Log::info('Login successful', ['email' => $credentials['email']]);

                return response()->json([
                    'token' => $token,
                    'user' => $user
                ]);
            } catch (\Exception $e) {
                Log::error('Token creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'message' => 'Failed to create authentication token'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Login error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }
} 