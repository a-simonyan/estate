<?php

namespace App\GraphQL\Queries;

use Auth;
use App\Property;

class UserProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;
        $property_id = $args['id'];

        $property = Property::find($property_id);                            

        if($property&&$property->user->id == $user_id){

            return $property;

        } 

        return null;
    }
}
