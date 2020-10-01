<?php

namespace App\GraphQL\Queries;

use App\Property;

class PropertiesRejected
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };



        $properties = Property::where('is_delete', false)->where('is_public_status','rejected')->orderBy($field, $order)->get();

        return $properties;
    }
}
