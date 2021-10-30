<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    public $timestamps = false;
    protected $table = "currency_types";
    protected $fillable = ['name','symbol','is_current','rate'];


    public function property_deals(){
        return $this->hasMany('App\PropertyDeal','currency_type_id','id'); 
    }

    public function suggests_price_property(){
        return $this->hasMany('App\SuggestsPriceProperty','currency_type_id','id');
    }
}
