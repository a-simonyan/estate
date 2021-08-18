<?php

namespace App\GraphQL\Mutations;

use App\UserFavoriteProperty;
use Auth;

class DeleteUserFavoritePropertys
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_id = Auth::user()->id;

        foreach($args['ids'] as $userFavoriteProperty_id){
        
             $userFavoriteProperty_user_id = UserFavoriteProperty::find($userFavoriteProperty_id)->user_id;
     
             if($userFavoriteProperty_user_id ==  $user_id ){
                 UserFavoriteProperty::where('id', $userFavoriteProperty_id)->delete();
             } else {
                 
                return ['status' => false ];
             }

        }

        return ['status' => true ];

    }
}
