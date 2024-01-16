<?php

namespace App\GraphQL\Queries;

use App\Http\Traits\GetIdTrait;
use App\Filter;
Use App\PropertyType;

class GetPropertyTypeFilters
{
    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $property_type =  $args['property_type'];
        $property_type_id = $this->getKeyId(PropertyType::Class,'name',$property_type);

        $filters = PropertyType::find($property_type_id)->filters;

        return $filters;
    }
}
