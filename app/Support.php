<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table="supports";

    protected $fillable=['user_id', 'name', 'email', 'text', 'is_answered'];


    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id'); 
    }
}
