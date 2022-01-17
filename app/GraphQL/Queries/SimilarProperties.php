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
            $propertyClass = $propertyClass->where('is_delete', false)
                                           ->where('is_archive', false)
                                           ->where('is_save', false)
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
            ->groupBy(DB::raw('id, property_key,property_type_id, user_id, bulding_type_id, latitude, longitude, address, postal_code ,property_state, review, is_public_status, is_save, is_delete, created_at, updated_at, email, is_address_precise, view, update_count, last_update, next_update, is_archive, is_bids, distance, is_top, top_start, top_end, same_place_group'))
            ->having("distance", "<", $radius)
            ->orderBy("distance");
    
            return $propertyClass->paginate($first,['*'],'page', $page);;
        }

        return null;
    }
}
