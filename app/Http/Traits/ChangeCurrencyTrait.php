<?php

namespace  App\Http\Traits;

use App\CurrencyType;

trait ChangeCurrencyTrait {
    
    public function changeCurrency($price, $currency_type_id, $like_currency_type_id) {
      
       $currency        = CurrencyType::find($currency_type_id);
       $currency_like   = CurrencyType::find($like_currency_type_id);

       $currency_rate      = $currency ? $currency->rate : 1;
       $currency_like_rate = $currency_like ? $currency_like->rate : 1;
       if($currency_type_id == $like_currency_type_id){
           $change_price = $price;
       } else {
           $change_price = ($price*$currency_rate)/$currency_like_rate;
       }


       return $change_price; 

    }


}