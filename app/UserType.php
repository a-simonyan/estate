<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = false;
    protected $table="user_types";
    protected $fillable=['name'];

    public function users(){
        return $this->hasMany('App\User','user_type_id','id');
    }
}
