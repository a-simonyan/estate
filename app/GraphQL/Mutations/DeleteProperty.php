<?php

namespace App\GraphQL\Mutations;

use App\Property;
use Auth;
use App\Exceptions\SendException;
use App\Events\PropertyDelete;


class DeleteProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth = Auth::user();
        $property_id = $args['id'];
        $property = Property::find($property_id);

        if($user_auth->id == $property->user_id){
            $property->update(['is_delete'=>true]);
            event( new PropertyDelete($property_id) );
          
            return $property;

        } else {
             throw new SendException(
                'error',
                __('messages.not_have_permission')
              );
        }
    }

 
}
