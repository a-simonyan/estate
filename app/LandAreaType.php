<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LandAreaType extends Model
{
    public $timestamps = false;
    protected $table = "land_area_types";
    protected $fillable = ['name'];

    public function properties(){
        return $this->hasMany('App\Property','land_area_type_id','id');
    }
}
