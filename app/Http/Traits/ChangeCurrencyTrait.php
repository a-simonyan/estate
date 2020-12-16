<?php

namespace  App\Http\Traits;

use App\CurrencyType;

trait ChangeCurrencyTrait {
    
    public function changeCurrency($price, $currency_type_id, $like_currency_type_id) {
      
     $currency        = CurrencyType::find($currency_type_id);   
     $currency_like   = CurrencyType::find($like_currency_type_id);

    //    foreach($currency_values as $currency_value){
    //       if(!$currencies&&$currency_value['currency_type_id'] == $currency_type_id){
    //           $currencies = $currency_value['value'];
    //       }
    //       if(!$currencies_like&&$currency_value['currency_type_id'] == $like_currency_type_id){
    //          $currencies_like = $currency_value['value'];
    //        }
    //        if($currencies&&$currencies_like){
    //          break;
    //        }
    //    }

       $currency_rate      = $currency ? $currency->rate : 1;
       $currency_like_rate = $currency_like ? $currency_like->rate : 1;
       $change_price = ($price*$currency_rate)/$currency_like_rate;


       return $change_price; 

    }


}