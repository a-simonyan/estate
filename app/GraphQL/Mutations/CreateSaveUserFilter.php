<?php

namespace App\GraphQL\Mutations;

use App\SaveUserFilter;
use Auth;

class CreateSaveUserFilter
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if(count($args)) {
            $user_id = Auth::user()->id;
            $json_properties_filters = json_encode($args);

            $saveUserFilter = SaveUserFilter::create([
                'properties_filters' => $json_properties_filters,
                'user_id' => $user_id
            ]);
            if ($saveUserFilter) {
                return ['status' => true];
            };
        }
        return ['status' => false ];
    }
}
