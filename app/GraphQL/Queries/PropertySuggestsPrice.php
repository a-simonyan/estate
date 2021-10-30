<?php

namespace App\GraphQL\Queries;

use Auth;
use App\SuggestsPriceProperty;


class PropertySuggestsPrice
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {

        $first   = !empty($args['first']) ? $args['first'] : 10;
        $page    = !empty($args['page']) ? $args['page'] : 1;
        $checked = !empty($args['checked']) ? $args['checked'] : false ;  

        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };
   
        $suggestsPriceProperty = SuggestsPriceProperty::where('is_delete', false)
                                                      ->where('is_checked', $checked)
                                                      ->where('property_id', $args['property_id'])
                                                      ->orderBy($field, $order)
                                                      ->paginate($first,['*'],'page', $page);

        
        return $suggestsPriceProperty;                                              


    }
}
