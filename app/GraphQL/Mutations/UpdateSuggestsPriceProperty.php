<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\SuggestsPriceProperty;
use App\Events\SendMailSuggestsPrice;

class UpdateSuggestsPriceProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;
        $arrayData   = [];
        $suggestsPriceProperty = SuggestsPriceProperty::find($args['id']);
        if($suggestsPriceProperty->user->id == $user_id){

            if(!empty($args['property_id'])){
                $arrayData['property_id'] = $args['property_id'];
            }
            if(!empty($args['price'])){
                $arrayData['price'] = $args['price'];
            }
            if(!empty($args['currency_type_id'])){
                $arrayData['currency_type_id'] = $args['currency_type_id'];
            }
            if(!empty($args['end_time'])){
                $arrayData['end_time'] = $args['end_time'];
            }
           
            $suggestsPriceProperty->update($arrayData);                         
     
            if($suggestsPriceProperty->property->email){
               event( new SendMailSuggestsPrice($suggestsPriceProperty) );
            }

        }


        return  $suggestsPriceProperty;     
    }
}
