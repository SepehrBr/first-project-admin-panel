<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    use HasFactory;



    protected  $fillable = [
        'user_id',
        'code',
        'expired_at'
    ];

    public  $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeGenerateCode($query, $user)
    {
        /* in this method user has same code until 10 mins. meaning if he doesnt verify the code, until 10 mins the code is same. */
        /*
        if ($code = $this->getAliveCodeForUser($user)) {
            $code = $code->code;
        } else {
            do{
                $code = mt_rand(100000, 999999);
            } while ($this->checkCodeIsUnique($user, $code));

            // store code
            $user->activeCode()->create([
                'code' => $code,
                'expired_at' => now()->addMinutes(10)
            ]);
        }
*/

        // in this method unlike above, even if user doesnt verify token, for every login he will get new token which every one of them expires until 10 mins

        do{
            $code = mt_rand(100000, 999999);
        } while ($this->checkCodeIsUnique($user, $code));

        // store code
        $user->activeCode()->create([
            'code' => $code,
            'expired_at' => now()->addMinutes(10)
        ]);

        return $code;
    }
    private function checkCodeIsUnique($user, int $code)
    {
        return !! $user->activeCode()->whereCode($code)->first();
        // return !! $user->activeCode()->where('code', $code)->first();

    }
    private function getAliveCodeForUser($user)
    {
        return $user->activeCode()->where('expired_at', '>', now())->first();
    }

    // verify code
    public function scopeVerifyCode($query, $code, $user)
    {
        return !! $user->activeCode()->whereCode($code)->where('expired_at', '>', now())->first();
    }
}
