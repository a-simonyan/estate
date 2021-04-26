<?php

namespace App\GraphQL\Queries;
use App\Property;
use Auth;


class UserProperties
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;
       
        $is_public_status = !empty($args['is_public_status'])? $args['is_public_status']:'published';
        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;

        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };

        $properties = Property::where('user_id',$user_id)
                               ->where('is_delete', false)
                               ->where('is_save', false)
                               ->where('is_public_status', $is_public_status)
                               ->orderBy($field, $order)
                               ->paginate($first,['*'],'page', $page);

        return $properties;
    }
}
