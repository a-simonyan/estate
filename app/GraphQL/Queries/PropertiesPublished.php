<?php

namespace App\GraphQL\Queries;

use App\Property;

class PropertiesPublished
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $field = 'last_update';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };



        $properties = Property::whereNull('deleted_at')->where('is_public_status','published')->orderBy($field, $order)->get();

        return $properties;
    }
}
