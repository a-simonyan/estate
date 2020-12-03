<?php

namespace App\GraphQL\Queries;

use App\Property;
use App\Filter;
Use App\PropertyType;
use App\PropertyDeal;
use DB;
use App\Http\Traits\GetIdTrait;

class PropertiesPublishedFilters
{
    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $propertyClass = Property::with('filters_values');
        $property=$propertyClass;
        $first = false;

     


        // $latitude= 40.177635;
        // $longitude= 44.512467;


        if(!empty($args['place'])){

            $place = $args['place'];
            
            $radius=empty($place['radius']) ? 5 : $place['radius'];
    
                  if($first){
              
                    
                    $property=$propertyClass::from(DB::raw("(select *,
                       ( 6371 * acos( cos( radians(?) ) *
                           cos( radians( latitude) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                       ) AS distance from properties) as t"))
                       ->groupBy(DB::raw('id, property_key,property_type_id, user_id, bulding_type_id, latitude, longitude, address, postal_code ,property_state, review, is_public_status, is_save, is_delete, created_at, updated_at, distance'))
                       ->having("distance", "<", $radius)
                       ->orderBy("distance")
                       ->setBindings([$place['latitude'], $place['longitude'], $place['latitude']]);
                     
                                           
    
                } else {
    
                    $property=$propertyClass->from(DB::raw("(select *,
                       ( 6371 * acos( cos( radians(?) ) *
                           cos( radians( latitude) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                       ) AS distance from properties) as t"))
                       ->groupBy(DB::raw('id, property_key,property_type_id, user_id, bulding_type_id, latitude, longitude, address, postal_code ,property_state, review, is_public_status, is_save, is_delete, created_at, updated_at, distance'))
                       ->having("distance", "<", $radius)
                       ->orderBy("distance")
                       ->setBindings([$place['latitude'], $place['longitude'], $place['latitude']]);
    
                }

                $propertyClass=$property;
                $first=false;
         

        }







        if(!empty($args['filters'])){
            $filters = $args['filters'];
    
            foreach($filters as $filter){
                $filter_id = $this->getKeyId(Filter::Class,'name',$filter['filter']);
                if($first){
                     $property=$propertyClass::whereHas('filters_values' , function ($query) use ($filter,$filter_id){
                          $query->where(function ($query) use ($filter,$filter_id) {
                             $query->where('filter_id',$filter_id);
                             $query->where('value',$filter['value']);
                         });
             
                     });
                } else {
                    $property=$propertyClass->whereHas('filters_values' , function ($query) use ($filter,$filter_id){
                
                         $query->where(function ($query) use ($filter,$filter_id) {
                            $query->where('filter_id',$filter_id);
                            $query->where('value',$filter['value']);
                        });
            
                    });
    
                }
    
                $propertyClass=$property;
                $first=false;
    
           }

        }

        // return dd($propertyClass->get());


      






      

        




        if($first){
            $properties = $property::where('is_delete', false)->where('is_public_status','published')->orderBy('created_at', 'DESC')->get();
        } else {
          $properties = $property->where('is_delete', false)->where('is_public_status','published')->orderBy('created_at', 'DESC')->get();
               
        }


    
        return $properties;
}



}
