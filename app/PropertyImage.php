<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table="property_images";
    protected $fillable=['property_id','name','index'];

   public function  property(){
       return $this->belongsTo('App\Property','property_id','id');
   }

    
}
