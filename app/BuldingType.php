<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuldingType extends Model
{   
    public $timestamps = false;
    protected $table = "bulding_types";
    protected $fillable = ['name'];

    public function properties(){
        return $this->hasMany('App\Property','bulding_type_id','id');
    }
  
}
