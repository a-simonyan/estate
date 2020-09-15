<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
  public $timestamps = false;
  protected $table = "property_types";
  protected $fillable = ['name','icon_class'];


  public function properties(){
    return $this->hasMany('App\Property','property_type_id','id');
  }
  public function filters(){
    return $this->belongsToMany('App\Filter','filter_property_types','property_type_id','filter_id');
  }
  
  
}
