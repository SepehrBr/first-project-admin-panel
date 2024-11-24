<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;

// traits
use App\Http\Controllers\Auth\TwoFactorAuthentication;

class GoogleAuthController extends Controller
{
    use TwoFactorAuthentication;
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->email)->first();

            if (! $user) {
                $user = User::updateOrCreate([
                    'id' => $googleUser->id
                ],[
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(\Str::random(16)),
                    'two_factor_auth' => 'off',
                    'email_verified_at' => now()
                ]);
            }

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            auth()->loginUsingId($user->id);

            return $this->loggedIn($request, $user) ?: redirect('/');

        } catch (\Exception $e) {
            Alert::error('Error!', 'There was some error while logging in');
            return redirect('/login');
        }
    }
}
