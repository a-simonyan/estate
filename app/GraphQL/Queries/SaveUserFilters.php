<?php

namespace App\GraphQL\Queries;

use App\SaveUserFilter;
use Auth;

class SaveUserFilters
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_id = Auth::user()->id;

        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };

        $saveUserFilters = SaveUserFilter::where('user_id',$user_id)->orderBy($field, $order)->get();

        $saveUserFilterJson=[];
        
        foreach($saveUserFilters as $saveUserFilter){
            $properties_filters = json_decode($saveUserFilter->properties_filters);
            $properties_filters->id = $saveUserFilter->id;
            $saveUserFilterJson[] =  $properties_filters;
        }

       return $saveUserFilterJson;
    }
}
