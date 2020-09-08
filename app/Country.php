<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    protected $table = "countries";
    protected $fillable = ['name'];

    public function properties(){
        return $this->hasMany('App\Property','country_id','id');
    }
}
