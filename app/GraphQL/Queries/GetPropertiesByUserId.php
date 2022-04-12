<?php

namespace App\GraphQL\Queries;

use App\Property;

class GetPropertiesByUserId
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;
        $user_id = $args['id'];
        
        $properties = Property::where('user_id',$user_id)
                              ->where('is_delete', false)
                              ->where('is_archive', false)
                              ->where('is_save', false)
                              ->where('is_public_status','published')
                              ->orderBy('last_update','DESC')
                              ->paginate($first,['*'],'page', $page);
        
        $total = $properties->total();
        $lastPage = $properties->lastPage();                           

        return ['properties' => $properties, 'total' => $total, 'lastPage' => $lastPage];
    }
}
