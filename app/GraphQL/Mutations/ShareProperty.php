<?php

namespace App\GraphQL\Mutations;

use App\PropertyShare;
use App\Property;

class ShareProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $property = Property::where('id', $args['id'])
            ->whereNull('deleted_at')
            ->whereNull('archived_at')
            ->whereNull('saved_at')
            ->where('is_public_status','published')->exists();

        if($property) {
            PropertyShare::create(['property_id' => $args['id']]);
            return ['status' => true ];
        }

        return ['status' => false ];
    }
}
