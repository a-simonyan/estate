<?php

namespace App\GraphQL\Queries;

use App\Filter;
use App\PropertyType;

class Test
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
    //   $pr =  PropertyType::where('id',1)->filter;

       return 'test';
    }
}
