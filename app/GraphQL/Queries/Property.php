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
        $user = auth('api')->user();
        $propertyClass = new PropertyModel;

        if($user){
            $user_id = $user->id;
            $propertyClass = $propertyClass->favorite($user_id);
        }

        $property_id = $args['id'];
        $property = $propertyClass->where('properties.id',$property_id)->first();

        if($property&&!$property->deleted_at&&$property->is_public_status == 'published'){
            return $property;
        } 

        return null;
    }
}
