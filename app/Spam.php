<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spam extends Model
{
    protected $table="spam";
    protected $fillable=['user_id', 'property_id'];

    public function   user(){
        return $this->belongsTo('App\User','user_id','id');
    } 
    public function  property(){
        return $this->belongsTo('App\Property','property_id','id');
    }

    public function spam_points(){
        return $this->belongsToMany('App\SpamPoint','spam_spam_points','spam_id','spam_point_id');
    }


}
