<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteProperty extends Model
{
    protected $table = "user_favorite_properties";
    protected $fillable = ['user_id','property_id'];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function  property(){
        return $this->belongsTo('App\Property','property_id','id');
    }

}
