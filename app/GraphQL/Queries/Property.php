<?php

namespace App\GraphQL\Queries;

use App\Property as PropertyModel;

class Property
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $property_id = $args['id'];
        $property = PropertyModel::Find($property_id);                            

        if($property&&!$property->deleted_at&&$property->is_public_status == 'published'){
            return $property;
        } 

        return null;
    }
}
