<?php

namespace App\GraphQL\Mutations;

use App\UserFavoriteProperty;
use Auth;

class DeleteUserFavoriteProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $userFavoriteProperty_id = $args['id'];
        $user_id = Auth::user()->id;

        $userFavoriteProperty_user_id = UserFavoriteProperty::find($userFavoriteProperty_id)->user_id;

        if($userFavoriteProperty_user_id ==  $user_id ){
            UserFavoriteProperty::where('id', $userFavoriteProperty_id)->delete();

            return ['status' => true ];
        }

        return  ['status' => false ];;
    }
}
