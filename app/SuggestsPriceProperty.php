<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuggestsPriceProperty extends Model
{
    protected $table = "suggests_price_properties";
    protected $fillable = [
                          'user_id',
                          'property_id',
                          'price',
                          'currency_type_id',
                          'end_time',
                          'is_checked',
                          'is_delete' 
                         ];
    protected $with = [
       'user',
       'property',
       'currency_type' 
    ];                     

     public function user(){
         return $this->belongsTo('App\User','user_id','id');
     }
                         
     public function property(){
         return $this->belongsTo('App\Property','property_id','id');
     }
   
     public function currency_type(){
         return $this->belongsTo('App\CurrencyType','currency_type_id','id');
     }        
     
     

}
