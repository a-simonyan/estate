<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\SuggestsPriceProperty;

class DeleteSuggestsPriceProperty
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
        if($suggestsPriceProperty->user->id == $user_id || $suggestsPriceProperty->property->user->id == $user_id){

            $suggestsPriceProperty->delete();
            return ['status' => true ];
        }

        return ['status' => false ];
    }
}
