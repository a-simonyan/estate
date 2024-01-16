<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\TranslationTrait;

class PropertyType extends Model
{
  use TranslationTrait;

  public $timestamps = false;
  protected $table = "property_types";
  protected $fillable = ['name'];

  public function getNameAttribute($value)
  {
      return $this->translat($value);
  }


  public function properties(){
    return $this->hasMany('App\Property','property_type_id','id');
  }
  public function filters(){
    return $this->belongsToMany('App\Filter','filter_property_types','property_type_id','filter_id');
  }
  
  
}
