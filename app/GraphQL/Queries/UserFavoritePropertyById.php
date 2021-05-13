<?php

namespace App\GraphQL\Queries;

use App\UserFavoriteProperty;
use Auth;
use App\Exceptions\SendException;

class UserFavoritePropertyById
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;

        $userFavoriteProperty = UserFavoriteProperty::where('id',$args['id'])->where('user_id',$user_id)->first();

        if( $userFavoriteProperty){
            return  $userFavoriteProperty;
        } else {
            throw new SendException(
                'error',
                __('messages.not_have_permission')
            );
        }

    }
}
