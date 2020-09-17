<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;
use App\Singleton\RestUrl;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    /**
     * Verify email url
     *
     */
    public $url="";

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'full_name','picture', 'email','user_type_id','password','is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail($this->url));
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }



    public function user_type(){
        return $this->belongsTo('App\UserType','user_type_id','id');
    }

    public function phones(){
        return $this->hasMany('App\Phone','user_id','id');
    }
    public function properties(){
        return $this->hasMany('App\Property','user_id','id');
    }

}
