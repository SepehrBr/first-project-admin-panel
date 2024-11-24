<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Routing\Route;
use Laravel\Sanctum\HasApiTokens;
use Modules\Discount\Entities\Discount;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'email_verified_at',
        'two_factor_auth',
        'is_superuser',
        'is_staff',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        // ACL, Gate and Policy related
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function rules()
    {
        return $this->belongsToMany(Rule::class);
    }
    public function hasPermission($permission)
    {
        return  $this->hasRule($permission->rules);
    }
    public function hasRule($rules) : bool
    {
        return !! $rules->intersect($this->rules)->all();
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    // reset email
        /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // reset email verification
        /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    // hash password
    public function setPasswordAttribute($value)
    {

        return $this->attributes['password'] = bcrypt($value);

    }

    // activecode and twofactor auth
    public function activeCode()
    {
        return $this->hasMany(ActiveCode::class);
    }
    public function hasTwoFactorAuthenticationEnabled()
    {
        return  $this->two_factor_auth !== 'off';
    }
    public function hasSmsTwoFactorAuthenticationEnabled()
    {
        return $this->two_factor_auth == 'sms';
    }

    // admin middleware funcs
    public function isSuperUser()
    {
        return $this->is_superuser;
    }
    public function isStaff()
    {
        return $this->is_staff;
    }
    public function makeSuperuser()
    {
        return $this->forceFill([
            'is_superuser' => true
        ])->save();
    }
    public function makeStaff()
    {
        return $this->forceFill([
            'is_staff' => true
        ])->save();
    }


    // product functions
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
