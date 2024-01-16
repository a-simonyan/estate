<?php

namespace App\Singleton;

class RestCurrency{

     public $currency_id=null;

     public function setCurrency($currency_id){

         $this->currency_id = $currency_id ? $currency_id : null;

     }
    
}