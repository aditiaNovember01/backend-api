<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Jika login berhasil, redirect ke halaman dashboard
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        // Jika login gagal, kembali ke form login dengan pesan error
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()), // random password
                ]);
            }
            Auth::login($user);
            $token = $user->createToken('web')->plainTextToken;
            // Redirect ke dashboard
            return redirect('/dashboard')->with('token', $token);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Gagal login dengan Google: ' . $e->getMessage()]);
        }
    }
}
