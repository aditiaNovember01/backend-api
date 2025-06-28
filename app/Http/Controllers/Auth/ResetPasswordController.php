<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Cari email dan redirect ke form reset jika ditemukan
    public function findEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }
        return redirect()->route('password.resetForm', ['email' => $user->email]);
    }

    // Tampilkan form reset password
    public function showResetForm($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        return view('auth.passwords.reset', compact('email'));
    }

    // Proses reset password
    public function reset(Request $request, $email)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::where('email', $email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/login')->with('success', 'Password berhasil direset, silakan login!');
    }
}
