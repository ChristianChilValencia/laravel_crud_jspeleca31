<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('books.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('books.index'));
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Token CRUD
    public function getToken(Request $request)
    {
        $user = Auth::user();
        $token = AccessToken::where('user_id', $user->id)->first();
        $now = Carbon::now();
        if ($token && $now->lessThan($token->expires_at)) {
            return response()->json(['token' => $token->token, 'expires_at' => $token->expires_at]);
        }
        // Expired or not exists, generate new
        if ($token) $token->delete();
        $plainToken = bin2hex(random_bytes(32));
        $expiresAt = $now->copy()->addDay();
        $token = AccessToken::create([
            'user_id' => $user->id,
            'token' => $plainToken,
            'expires_at' => $expiresAt,
        ]);
        return response()->json(['token' => $plainToken, 'expires_at' => $expiresAt]);
    }
}
