<?php

namespace App\GraphQL\Mutations;

class TestI
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
       return  json_encode($args['text']);
    }
}
