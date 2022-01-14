<?php

namespace App\GraphQL\Mutations;
use Carbon\Carbon;

class SetPropertyTop
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth = Auth::user();
        $property_id = $args['id'];
        $property = Property::find($property_id);
        $nextUpdateDaysCount = 7;

        if($user_auth->id == $property->user_id){
            $property->is_top = true;
            $property->top_start =  Carbon::now();
            $property->top_start =  Carbon::now()->addDays($nextUpdateDaysCount);
            $property->save();

            return $property;
        }

        return null;

    }
}
