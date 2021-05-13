<?php

namespace App\GraphQL\Queries;
use App\UserFavoriteProperty;
use Auth;

class UserFavoriteProperties
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;

        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;

        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };

        $userFavoriteProperties = UserFavoriteProperty::where('user_id',$user_id)
            ->orderBy($field, $order)
            ->paginate($first,['*'],'page', $page);

        return $userFavoriteProperties;


    }
}
