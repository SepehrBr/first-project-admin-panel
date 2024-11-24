<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Models\User;
use App\Notifications\LoginToWebNotification;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;



class AuthenticateTokenController extends Controller
{
    public function getToken(Request $request)
    {

        if ( ! $request->session()->has('auth')) {
        return redirect('/login');
        }

        $request->session()->reflash();

        return view('auth.token');
    }
    public function postToken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);
        if ( ! $request->session()->has('auth')) {
            return redirect('/login');
        }

        $user = User::findOrFail($request->session()->get('auth.user_id'));
        $status = ActiveCode::verifyCode($request->token, $user);

        if (! $status) {
            Alert::error('Error', 'authentication code is incorrect!');
            return redirect(route('login'));
        }

        if (auth()->loginUsingId($user->id, $request->session()->get('auth.remember'))) {
            $user->notify(new LoginToWebNotification());
            $user->activeCode()->delete();
            Alert::success('login', 'login successful');
            return redirect('/');
        }

        return redirect(route('login'));
    }
}
