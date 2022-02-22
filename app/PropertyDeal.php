<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CurrencyType;

class PropertyDeal extends Model
{

    public $timestamps = false;
    protected $table ="property_deals";
    protected $fillable= ['property_id','deal_type_id','price','currency_type_id'];

    public function property(){
        return $this->belongsTo('App\Property','property_id','id');
    }
    public function deal_type(){
        return $this->belongsTo('App\DealType','deal_type_id','id');
    }
    public function currency_type(){
        return $this->belongsTo('App\CurrencyType','currency_type_id','id');
    }
    public function getPriceUsdAttribute(){
          $usd =  CurrencyType::where('name','USD')->first(['id','rate']);
          if($usd&&$usd->id == $this->currency_type_id){
             return $this->price;
          } else {
            
            $currencyType = CurrencyType::where('id',$this->currency_type_id)->first(['rate']);

            return round(($this->price*$currencyType->rate)/$usd->rate, 2);
          }
    }
    public function getPriceSelAttribute(){
        $currencyId = app('RestCurrency')->currency_id;

        $selCurrencyType = CurrencyType::find($currencyId);

        if(!$selCurrencyType){
            $selCurrencyType =  CurrencyType::where('name','USD')->first();
        } 

        if($currencyId == $this->currency_type_id){
            return ['currency_type' => $selCurrencyType ,'price' => $this->price];
         } else {
          
            $currencyType = CurrencyType::where('id',$this->currency_type_id)->first(['rate']);

            return ['currency_type' =>  $selCurrencyType ,'price' => round(($this->price*$currencyType->rate)/$selCurrencyType->rate, 2)];
        }
        

    }
}
