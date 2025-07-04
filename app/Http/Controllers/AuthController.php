<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show the register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->expectsJson()) {
            // Generate token for API
            $token = $this->generateOrRefreshToken($user);
            return response()->json([
                'message' => 'Registration successful',
                'user' => $user,
                'token' => $token,
                'expires_at' => Carbon::now()->addDay()->toDateTimeString()
            ], 201);
        }

        // Web registration - log the user in
        Auth::login($user);
        $this->generateOrRefreshToken($user);
        
        return redirect('/books')->with('success', 'Registration successful!');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($request->expectsJson()) {
                // API login
                $token = $this->generateOrRefreshToken($user);
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'token' => $token,
                    'expires_at' => Carbon::now()->addDay()->toDateTimeString()
                ]);
            }

            // Web login
            $request->session()->regenerate();
            $this->generateOrRefreshToken($user);
            
            return redirect()->intended('/books')->with('success', 'Login successful!');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Handle user logout (Web)
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Logged out successfully!');
    }

    /**
     * Handle user logout (API)
     */
    public function apiLogout(Request $request)
    {
        // Delete current token
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get current token (API)
     */
    public function getToken(Request $request)
    {
        $user = $request->user();
        $token = $this->generateOrRefreshToken($user);
        
        return response()->json([
            'token' => $token,
            'expires_at' => Carbon::now()->addDay()->toDateTimeString()
        ]);
    }

    /**
     * Generate or refresh token for user
     */
    private function generateOrRefreshToken($user)
    {
        // Check if user has existing access token (custom model)
        $existingToken = $user->tokens()->first();
        if ($existingToken && !$existingToken->isExpired()) {
            return $existingToken->token;
        }
        // Remove old token if exists
        if ($existingToken) {
            $existingToken->delete();
        }
        $plainToken = \Illuminate\Support\Str::random(60);
        $user->tokens()->create([
            'token' => $plainToken,
            'expires_at' => now()->addDay(),
        ]);
        return $plainToken;
    }

    /**
     * Check if user's token is expired (middleware helper)
     */
    public function checkTokenExpiry(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $currentToken = $user->currentAccessToken();
        
        if ($currentToken) {
            $tokenCreatedAt = Carbon::parse($currentToken->created_at);
            $expiresAt = $tokenCreatedAt->addDay();
            
            if (Carbon::now()->greaterThan($expiresAt)) {
                // Token expired
                $currentToken->delete();
                return response()->json(['message' => 'Token expired'], 401);
            }
        }

        return response()->json(['message' => 'Token is valid']);
    }
}