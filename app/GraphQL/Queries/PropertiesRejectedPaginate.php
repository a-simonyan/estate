<?php

namespace App\GraphQL\Queries;

use App\Property;

class PropertiesRejectedPaginate
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;

        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };

        $properties = Property::whereNull('deleted_at')->where('is_public_status','rejected')->paginate($first,['*'],'page', $page);

        return $properties;
    }
}
