<?php

namespace App\GraphQL\Mutations;

use App\SaveUserFilter;
use Auth;

class UpdateSaveUserFilter
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $saveUserFilter_id = $args['id'];
        $user_id = Auth::user()->id;

        $saveUserFilter_user_id = SaveUserFilter::find($saveUserFilter_id)->user->id;

        $input = collect($args)->except(['id'])->toArray();

        if($saveUserFilter_user_id ==  $user_id ){

            $json_properties_filters = json_encode($input);

            $saveUserFilter = SaveUserFilter::where('id', $saveUserFilter_id)->update([
                'properties_filters' => $json_properties_filters
               ]);

            return true;
        } else {

            return false;
        }

     
        
    }
}
