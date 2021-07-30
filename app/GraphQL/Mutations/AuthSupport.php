<?php

namespace App\GraphQL\Mutations;

use App\Support;
use Auth;

class AuthSupport
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $support = Support::create([
                        'user_id' => $user_auth->id,
                        'name'    => $user_auth->full_name,
                        'email'   => $user_auth->email,
                        'text'    => $args['text'],
        ]);

        if($support){
            return  ['status' => true];
        } 
        
        return  ['status' => false];

    }
}
