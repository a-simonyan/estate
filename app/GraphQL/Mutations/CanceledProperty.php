<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Property;

class CanceledProperty
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

        if($property&&$property->user->id == $user_id&&$property->is_public_status=='under_review'){

            $property->is_public_status='canceled';
            $property->save();

            return [ 'status' => true ];
        }

        return [ 'status' => false ];
    }
}
