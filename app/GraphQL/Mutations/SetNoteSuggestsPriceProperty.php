<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\SuggestsPriceProperty;

class SetNoteSuggestsPriceProperty
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

            $suggestsPriceProperty->update(['note' => $args['note']]);
        }
        
        return $suggestsPriceProperty;
    }
}
