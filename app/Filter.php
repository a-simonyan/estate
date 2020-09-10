<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public $timestamps = false;
    protected $table = "filters";
    protected $fillable = ['name','filter_type'];

    public function filters_values(){
        return $this->hasMany('App\FiltersValue','filter_id','id');
    }
    public function property_types(){
        return $this->belongsToMany('App\PropertyType','filter_property_types','filter_id','property_type_id');
    }
    
    
}
