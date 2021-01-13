<?php

namespace App\GraphQL\Queries;

use App\SaveUserFilter;
use Auth;


class SaveUserFilterById
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $saveUserFilter_id = $args['id'];
        $user_id = Auth::user()->id;

        $saveUserFilter = SaveUserFilter::find($saveUserFilter_id);
        $saveUserFilter_user_id = $saveUserFilter->user->id;

        if($saveUserFilter_user_id ==  $user_id ){
            $properties_filters = json_decode($saveUserFilter->properties_filters);
            $properties_filters->id = $saveUserFilter->id;

            return $properties_filters;
        }

    }
}
