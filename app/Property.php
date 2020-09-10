<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = "properties";
    protected $fillable = ['property_type_id',
                           'user_id',
                           'property_number',
                           'bulding_type_id',
                           'latitude',
                           'longitude',
                           'country_id',
                           'city_id',
                           'address',
                           'postal_code'];


   public function   property_type(){
       return $this->belongsTo('App\PropertyType','property_type_id','id');
   }  
   public function   user(){
      return $this->belongsTo('App\User','user_id','id');
   }               
   public function   bulding_type(){
       return $this->belongsTo('App\BuldingType','bulding_type_id','id');
   }          
   public function   country(){
       return $this->belongsTo('App\Country','country_id','id');
   }    
   public function   city(){
       return $this->belongsTo('App\City','city_id','id');
   }     
   public function filters_values(){
       return $this->hasMany('App\FiltersValue','property_id','id');
   }
   public function property_images(){
       return $this->hasMany('App\PropertyImage','property_id','id'); 
   }
   public function property_deals(){
       return $this->hasMany('App\PropertyDeal','property_id','id'); 
   }
   public function deal_types(){
    return $this->belongsToMany('App\DealType','property_deals','property_id','deal_type_id');
   }


}
