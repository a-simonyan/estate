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
        
        $properties = Property::where('properties.user_id',$user_id)
                              ->whereNull('deleted_at')
                              ->whereNull('archived_at')
                              ->whereNull('saved_at')
                              ->where('is_public_status','published');

        $auth_user = auth('api')->user();

        if($auth_user){
            $auth_user_id = $auth_user->id;
            $properties = $properties->favorite($auth_user_id);
        }

        $properties = $properties->orderBy('last_update','DESC')
                                 ->paginate($first,['*'],'page', $page);
        
        $total = $properties->total();
        $lastPage = $properties->lastPage();                           

        return ['properties' => $properties, 'total' => $total, 'lastPage' => $lastPage];
    }
}
