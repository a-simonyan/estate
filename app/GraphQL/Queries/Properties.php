<?php

namespace App\GraphQL\Queries;

use App\Property;

class Properties
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $pageNumber=2;
        $properties = Property::where('is_delete', false)->get();

        return $properties;
    }
}
