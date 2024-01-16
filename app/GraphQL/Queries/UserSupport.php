<?php

namespace App\GraphQL\Queries;

use App\Support;
use Auth;

class UserSupport
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
      
        $user_auth_id   = Auth::user()->id;
        $support = Support::where('id', $args['id'])->where('user_id',  $user_auth_id)->first();

        
        return $support;
       
    }
}
