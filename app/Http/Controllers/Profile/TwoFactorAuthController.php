<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Notifications\ActiveCodeNotification;
use Illuminate\Http\Request;

class TwoFactorAuthController extends Controller
{

    public function manageTwoFactor()
    {
        return view('profile.two-factor-auth');
    }
    public function postManageTwoFactor(Request $request)
    {
        $validateData = $this->validateRequestData($request);

        switch ($validateData['type']) {
            case 'sms':
                if ($request->user()->phone_number !== $validateData['phone']) {
                    // create code
                    $code = ActiveCode::generateCode($request->user());
                    $request->session()->flash('phone', $validateData['phone']);
                    // send code to user
                    $request->user()->notify(new ActiveCodeNotification($code, $validateData['phone']));

                    return redirect(route('profile.2fa.phone'));
                } else {
                    $request->user()->update([
                        'two_factor_auth' => 'sms'
                    ]);
                }
                break;
            default:
                $request->user()->update([
                    'two_factor_auth' => 'off'
                ]);
                break;
        }

        return back();
    }

    // refactor funcs
    private function validateRequestData(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:sms,off',
            'phone' => 'required_unless:type,off'
            // 'phone' => ['required_unless:type,off', Rule::unique('users', 'pnoe_number')->ignore($request->user()->id)]
            // this validation is for unique phone numbers for every user
        ]);

        return $validatedData;
    }
}
