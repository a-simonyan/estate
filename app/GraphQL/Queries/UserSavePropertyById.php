<?php

namespace App\GraphQL\Queries;

use App\Property;
use Auth;
use App\Exceptions\SendException;

class UserSavePropertyById
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;

        $property = Property::where('user_id',$user_id)
            ->where('id',$args['id'])
            ->whereNull('deleted_at')
            ->whereNotNull('saved_at')
            ->first();

        if( $property ){
            return  $property;
        } else {
            throw new SendException(
                'error',
                __('messages.not_have_permission')
            );
        }
    }
}
