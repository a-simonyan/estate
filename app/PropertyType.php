<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
  public $timestamps = false;
  protected $table = "property_types";
  protected $fillable = ['name'];


  public function properties(){
    return $this->hasMany('App\Property','property_type_id','id');
  }

  
}
