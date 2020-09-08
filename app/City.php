<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    protected $table = "cities";
    protected $fillable = ['name','parent_id'];

    public function properties(){
        return $this->hasMany('App\Property','city_id','id');
        
    }
}
