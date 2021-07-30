<?php

namespace App\GraphQL\Queries;

use App\Support;

class AdminSupports
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $supportClass = Support::with('user');
      
        if(isset($args['is_answered'])) {
            $supportClass = $supportClass->where('is_answered', $args['is_answered']);
        }

        if(!empty($args['user_id'])) {
            $supportClass = $supportClass->where('user_id', $args['user_id']);
        }

        if(!empty($args['name'])) {
            $supportClass = $supportClass->where('name','like', '%'.$args['name'].'%');
        }
        if(!empty($args['email'])) {
            $supportClass = $supportClass->where('email', $args['email']);
        }


        if(!empty($args['order_by'])) {
            $supportClass = $supportClass->orderBy('id', $args['order_by']);
        } else {
            $supportClass = $supportClass->orderBy('id', 'DESC');
        }

        /*add paginate*/
        if(!empty($args['paginate'])){
            $first = !empty($args['paginate']['first']) ? $args['paginate']['first'] : 10;
            $page  = !empty($args['paginate']['page']) ? $args['paginate']['page'] : 1;

            return $supportClass->paginate($first,['*'],'page', $page);
        }

        return $supportClass->get();
    }
}
