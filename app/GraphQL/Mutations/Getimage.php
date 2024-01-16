<?php

namespace App\GraphQL\Mutations;

class Getimage
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $storagePath = storage_path('app/tomato.jpg');

        $image = base64_encode(file_get_contents($storagePath));

        return $image;
    }
}
