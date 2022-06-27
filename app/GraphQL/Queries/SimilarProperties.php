<?php

namespace App\GraphQL\Queries;

use App\Property;
use DB;

class SimilarProperties
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $property_id = $args['id'];
        $property = Property::Find($property_id); 
        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;


        $radius = 10;

        if($property){
            $propertyClass = new Property;
            $propertyClass = $propertyClass->whereNull('deleted_at')
                                           ->whereNull('archived_at')
                                           ->whereNull('saved_at')
                                           ->where('is_public_status','published')
                                           ->where('id','!=', $property_id);
    
            $propertyClass = $propertyClass->where('property_type_id', $property->property_type_id, $property_id);


            $propertyClass = $propertyClass->from(DB::raw("(select *,
            ( 6371 * acos( cos( radians(".$property->latitude.") ) *
                cos( radians( latitude) )
                * cos( radians( longitude ) - radians(".$property->longitude.")
                ) + sin( radians(".$property->latitude.") ) *
                sin( radians( latitude ) ) )
            ) AS distance from properties) as properties"))
            ->having("distance", "<", $radius)
            ->orderBy("distance");
    
            return $propertyClass->paginate($first,['*'],'page', $page);;
        }

        return null;
    }
}
