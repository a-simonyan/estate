<?php

namespace App\GraphQL\Mutations;

use App\Support;

class GuestSupport
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $support = Support::create([
                        'name'  => $args['name'],
                        'email' => $args['email'],
                        'text'  => $args['text']
                    ]);

        if($support){
            return  ['status' => true];
        } 
        
        return  ['status' => false];
    }
}
