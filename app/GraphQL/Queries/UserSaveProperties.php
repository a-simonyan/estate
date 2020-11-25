<?php

namespace App\GraphQL\Queries;
use App\Property;
use Auth;

class UserSaveProperties
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;

        $properties = Property::where('user_id',$user_id)->where('is_delete', false)
                              ->where('is_save',true)->orderBy('created_at', 'DESC')
                              ->get();

        return $properties;
    }
}
