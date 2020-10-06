<?php

namespace App\GraphQL\Queries;
use Auth;
use App\User;

class UserProfile
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_id = Auth::user()->id;
        $user=User::find($user_id);

        return $user;
    }
}
