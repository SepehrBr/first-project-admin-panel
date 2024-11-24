<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TokenAuthController extends Controller
{
    public function getPhoneVerify(Request $request)
    {
        if (! $request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }

        $request->session()->reflash();

        return view('profile.phone-verify');
    }
    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if (! $request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }

        $status = ActiveCode::verifyCode($request->token, $request->user());
        if ($status) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_auth' => 'sms'
            ]);

            Alert::success('phone authorized', 'Success');
        } else {
            Alert::error('phone couldnt authoriz', 'Error');
        }

        return redirect(route('profile.2fa.manage'));
    }
}
