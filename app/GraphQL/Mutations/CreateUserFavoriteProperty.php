<?php

namespace App\GraphQL\Mutations;

use App\UserFavoriteProperty;
use App\Property;
use Auth;


class CreateUserFavoriteProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_id = Auth::user()->id;
        $property_id = $args['property_id'];
        
        $property = Property::find($property_id);

        if($property&&!$property->deleted_at){
            $userFavoriteProperty = UserFavoriteProperty::create([
                'user_id'     => $user_id,
                'property_id' => $property_id
            ]);

            return  $userFavoriteProperty;
        }

    }
}
