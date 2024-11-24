<?php namespace App\Http\Controllers\Auth;
      use App\Models\ActiveCode;
      use App\Notifications\ActiveCodeNotification;
      use App\Notifications\Channels\GhasedakChannel;
      use App\Notifications\LoginToWebNotification;
      use Illuminate\Http\Request;

trait TwoFactorAuthentication
{
    public function loggedIn(Request $request, $user)
    {
        if ($user->hasTwoFactorAuthenticationEnabled()) {
            $this->logoutAndRedirectToTokenEntry($request, $user);
        }

        $user->notify(new LoginToWebNotification());

        return false;
    }


    public function logoutAndRedirectToTokenEntry(Request $request, $user)
    {
        auth()->logout();

        $request->session()->flash('auth', [
            'user_id' => $user->id,
            'using_sms' => false,
            'remember' => $request->has('remember')
        ]);

        //
        if ($user->hasSmsTwoFactorAuthenticationEnabled()) {
            $code = ActiveCode::generateCode($user);

            $user->notify(new ActiveCodeNotification($code, $user->phone_number));

            $request->session()->push('auth.using_sms', true);
        }

        return redirect(route('2fa.token'));
    }

}
