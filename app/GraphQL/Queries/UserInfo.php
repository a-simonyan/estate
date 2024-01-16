<?php

namespace App\GraphQL\Queries;

use App\User;

class UserInfo
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
      $user = User::find($args['user_id']);

      return $user;
    }
}
