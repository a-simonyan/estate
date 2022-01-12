<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;
use App\Singleton\RestUrl;

class User extends Authenticatable 
// implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    /**
     * Verify email url
     *
     */
    public $url="";

    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'full_name',
     'picture', 
     'email',
     'user_type_id',
     'password',
     'is_admin',
     'is_delete',
     'first_time',
     'email_verified_at',
     'provider',
     'provider_id',
     'is_block',
     'reason',
     'block_start',
     'block_end',
     'last_active_time',
     'login_phone'
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

    public function findForPassport($username) {
        return $this->orWhere('email', $username)->orWhere('login_phone',$username)->first();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail($this->url));
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getPictureAttribute($value)
    {      
          if(is_null($value)){
                return [ 'original' => $value, 'min' => $value ];
          } else {
                return [ 'original' => url('storage/users/'.$value), 'min' => url('storage/users/min/'.$value) ]; 
          }

        //   if(is_null($value)){
        //     return $value;
        //   } else {
        //     return url('storage/users/'.$value); 
        //   }
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
    public function user_favorite_properties(){
        return $this->hasMany('App\UserFavoriteProperty','user_id','id');
    }
    public function saveUserFilters(){
        return $this->hasMany('App\SaveUserFilter', 'user_id', 'id');
    }

    public function notification_users_properties(){
        return $this->hasMany('App\NotificationUsersProperties','user_id','id');
    }
    public function supports(){
        return $this->hasMany('App\Support','user_id','id');
    }

    public function suggests_price_property(){
        return $this->hasMany('App\SuggestsPriceProperty','user_id','id');
    }

}
