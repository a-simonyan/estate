<?php

namespace App\GraphQL\Mutations;

use App\UserFavoriteProperty;
use App\Property;
use Auth;

class UpdateUserFavoriteProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_id = Auth::user()->id;
        $userFavoriteProperty_id = $args['id'];
        $property_id = $args['property_id'];

        $userFavoriteProperty = UserFavoriteProperty::find($userFavoriteProperty_id);
        
        $property = Property::find($property_id);

        if($userFavoriteProperty->user->id==$user_id&&$property&&!$property->deleted_at){
            $userFavoriteProperty->update([
                'user_id'     => $user_id,
                'property_id' => $property_id
            ]);

            $userFavoriteProperty = UserFavoriteProperty::find($userFavoriteProperty_id);
            
            return  $userFavoriteProperty;
        }
    }
}
