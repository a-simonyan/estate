<?php

namespace App\GraphQL\Queries;
use App\Property;

class PropertiesPaginate
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;
      

        $properties = Property::where('is_delete', false)->paginate($first,['*'],'page', $page);

        return $properties;
    }
}
