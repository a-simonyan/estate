<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\SuggestsPriceProperty;

class SetCheckedSuggestsPriceProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;

        $suggestsPriceProperty = SuggestsPriceProperty::find($args['id']);
        if($suggestsPriceProperty->property->user->id == $user_id){

            $suggestsPriceProperty->update(['is_checked' => $args['checked']]);
        }
        
        return $suggestsPriceProperty;
    }
}
