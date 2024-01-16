<?php

namespace App\GraphQL\Mutations;

use App\Spam;
use Auth;

class CreateSpam
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
       $user_auth   = Auth::user();
       $spam = Spam::create([
                    'user_id'     => $user_auth->id,
                    'property_id' => $args['property_id']
       ]);

       $spam->spam_points()->attach($args['points']);

       return $spam;

    }
}
