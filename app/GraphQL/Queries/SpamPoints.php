<?php

namespace App\GraphQL\Queries;

use App\SpamPoint;

class SpamPoints
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
       $spamPoint = SpamPoint::get();

       return $spamPoint;
    }
}
