<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\SuggestsPriceProperty;
use App\Events\SendMailSuggestsPrice;
use App\Property;

class CreateSuggestsPriceProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;
        $property    = Property::find($args['property_id']);
        
        if($property&&$property->is_bids){
            $suggestsPriceProperty = SuggestsPriceProperty::create([
                                        'user_id' => $user_id,
                                        'property_id' => $args['property_id'],
                                        'price' => $args['price'],
                                        'currency_type_id' => $args['currency_type_id'],
                                        'end_time' => !empty($args['end_time']) ? $args['end_time'] : null 
                                    ]);
    
            if($suggestsPriceProperty->property->email){
               event( new SendMailSuggestsPrice($suggestsPriceProperty) );
            }

            return  $suggestsPriceProperty;
        }


        return  null;                 


    }
}
