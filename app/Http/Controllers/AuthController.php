<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return redirect('/')->with('show_login', true);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:30',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // hashed by cast
            'phone' => $data['phone'] ?? null,
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Umefanikiwa kujisajili. Karibu!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Umefanikiwa kuingia.');
        }

        return back()->withErrors(['email' => 'Taarifa za kuingia hazikubaliki'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Umetoka nje.');
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);
        // Use Laravel's Password broker to send the reset link
        $status = \Illuminate\Support\Facades\Password::sendResetLink($data);

        if ($status == \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
