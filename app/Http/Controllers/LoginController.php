<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleLogin()
    {

        $googleUser = Socialite::driver('google')->user();

        $googleId = $googleUser->id;


        if (User::where('google_id', $googleId)->exists()) {
            $user = User::where('google_id', $googleId)->first();
            Auth::login($user);
            return redirect()->route('appointments.index');
        }

        $user = User::updateOrCreate([
            'google_id' => $googleId,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => $googleId,
            'google_id' => $googleId,
        ]);

        Auth::login($user);

        return redirect()->route('appointments.index');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('appointments.index'));
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }
}
