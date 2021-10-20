<?php

namespace App\GraphQL\Queries;

use Auth;

class UserActiveTime
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user = Auth::user();
        $user->update([
                      'last_active_time' => now()
                    ]);


      return $user;

    } 
}
