<?php

namespace App\GraphQL\Queries;

use Auth;
use App\SuggestsPriceProperty;

class UserSuggestsPriceProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;

        $first   = !empty($args['first']) ? $args['first'] : 10;
        $page    = !empty($args['page']) ? $args['page'] : 1;

        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };

   
        $suggestsPriceProperty = SuggestsPriceProperty::where('user_id',$user_id)
                                                      ->where('property_id', $args['property_id']);
        if(isset($args['checked'])){
            $suggestsPriceProperty->where('is_checked', $args['checked']);
        }

       

        $suggestsPriceProperty = $suggestsPriceProperty->orderBy($field, $order)
                                                       ->paginate($first,['*'],'page', $page);

        
        return $suggestsPriceProperty;           
    }
}
