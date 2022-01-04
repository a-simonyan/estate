<?php

namespace App\GraphQL\Queries;
use App\Property;

class PropertiesPublishedPaginate
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;

        $field = 'last_update';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };

        $properties = Property::where('is_delete', false)
                     ->where('is_archive', false)
                     ->where('is_public_status','published')
                     ->orderBy($field, $order)->paginate($first,['*'],'page', $page);

        return $properties;
    }
}
