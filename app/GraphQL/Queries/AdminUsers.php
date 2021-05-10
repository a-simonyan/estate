<?php

namespace App\GraphQL\Queries;

use App\User;
use App\UserType;
use App\Http\Traits\GetIdTrait;

class AdminUsers
{
    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $userClass = User::with('user_type');
        if(!empty($args['is_delete'])) {
            $userClass = $userClass->where('is_delete', $args['is_delete']);
        } else {
            $userClass = $userClass->where('is_delete', false);
        }

        if(!empty($args['user_type'])) {
            $user_type_id = $this->getKeyId(UserType::Class,'name',$args['user_type']);
            $userClass = $userClass->where('user_type_id',  $user_type_id);
        }

        if(!empty($args['user_id'])) {
            $userClass = $userClass->where('id', $args['user_id']);
        }

        if(!empty($args['full_name'])) {
            $userClass = $userClass->where('full_name','like', '%'.$args['full_name'].'%');
        }
        if(!empty($args['email'])) {
            $userClass = $userClass->where('email', $args['email']);
        }

        if(!empty($args['phone_number'])){
            $phone_number = $args['phone_number'];
            $userClass=$userClass->whereHas('phones' , function ($query) use ( $phone_number){
                    $query->where('number',$phone_number);
            });
        }

        if(!empty($args['order_by'])) {
            $userClass = $userClass->orderBy('id', $args['order_by_time']);
        } else {
            $userClass = $userClass->orderBy('id', 'DESC');
        }

        /*add paginate*/
        if(!empty($args['paginate'])){
            $first = !empty($args['paginate']['first']) ? $args['paginate']['first'] : 10;
            $page  = !empty($args['paginate']['page']) ? $args['paginate']['page'] : 1;

            return $userClass->paginate($first,['*'],'page', $page);
        }

        return $userClass->get();

    }
}
