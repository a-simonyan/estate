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

   public function getNameAttribute($value)
    {       
    //   if(is_null($value)){
    //       return [ 'original' => $value, 'min' => $value ];
    //   } else {
    //       return [ 'original' => url('storage/property/'.$value), 'min' => url('storage/property/min/'.$value) ]; 
    //   }
      
      
      if(is_null($value)){
          return [ 'original' => $value, 'min' => $value ];
      } else {
          return [ 'original' => $value, 'min' => $value ]; 
      }
    }  
    
}
