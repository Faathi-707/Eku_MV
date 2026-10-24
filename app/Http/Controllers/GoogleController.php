<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $g = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors('Google sign-in failed. Please try again.');
        }

        $user = User::where('email', $g->getEmail())->first();

        if (! $user) {
            // New person signing in with Google is always a citizen
            $user = new User();
            $user->forceFill([
                'name' => $g->getName(),
                'email' => $g->getEmail(),
                'role' => 'citizen',
                'google_id' => $g->getId(),
                'email_verified_at' => now(),
            ])->save();
        } elseif (! $user->google_id) {
            // Existing account: link Google but never change the role
            $user->forceFill(['google_id' => $g->getId()])->save();
        }

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}