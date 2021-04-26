<?php

namespace App\GraphQL\Queries;

use App\UserType;
use App\Property;
use App\Filter;
Use App\PropertyType;
use App\PropertyDeal;
use App\DealType;
use DB;
use App\Http\Traits\GetIdTrait;
use App\Http\Traits\ChangeCurrencyTrait;

class PropertiesPublishedFilters
{
    use GetIdTrait, ChangeCurrencyTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $propertyClass = Property::with('filters_values');
    

        if(!empty($args['place'])){

            $place = $args['place'];
            $radius=empty($place['radius']) ? 5 : $place['radius'];
                    $propertyClass=$propertyClass->from(DB::raw("(select *,
                       ( 6371 * acos( cos( radians(?) ) *
                           cos( radians( latitude) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                       ) AS distance from properties) as properties"))
                       ->groupBy(DB::raw('id, property_key,property_type_id, user_id, bulding_type_id, latitude, longitude, address, postal_code ,property_state, review, is_public_status, is_save, is_delete, created_at, updated_at, distance'))
                       ->having("distance", "<", $radius)
                       ->orderBy("distance")
                       ->setBindings([$place['latitude'], $place['longitude'], $place['latitude']]);

        }

        $propertyClass = $propertyClass->where('is_delete', false)->where('is_public_status','published');


         if(!empty($args['property_type'])){
            $property_type_id = $this->getKeyId(PropertyType::Class,'name',$args['property_type']);
            $propertyClass = $propertyClass->where('property_type_id',$property_type_id);
          }


          if(!empty($args['user_type'])){
            $user_type_id = $this->getKeyId(UserType::Class,'name',$args['user_type']);
            $propertyClass = $propertyClass->whereHas('user',function ($query) use ($user_type_id){
                                                         $query->where('user_type_id',$user_type_id);
                                                      });
          }

          if(!empty($args['area'])){

             $minMax = $args['area'];
             $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'area');

          }




          if(!empty($args['number_of_floors_of_the_building'])){

            $minMax = $args['number_of_floors_of_the_building'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'number_of_floors_of_the_building');

         }

         if(!empty($args['apartment_floor'])){

            $minMax = $args['apartment_floor'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'apartment_floor');

         }
         if(!empty($args['number_of_rooms'])){

            $minMax = $args['number_of_rooms'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'number_of_rooms');

         }

         if(!empty($args['number_of_bathrooms'])){

                    $filter_id = $this->getKeyId(Filter::Class,'name','number_of_bathrooms');
                    $number_of_bathrooms = $args['number_of_bathrooms'];
                    $propertyClass=$propertyClass->whereHas('filters_values' , function ($query) use ( $number_of_bathrooms,$filter_id){
                         $query->where(function ($query) use ($number_of_bathrooms, $filter_id) {
                            $query->where('filter_id',$filter_id);
                            $query->where('value',$number_of_bathrooms);
                        });
                    });

         }

         if(!empty($args['property_state'])){

            $propertyClass=$propertyClass->where('property_state',$args['property_state']);          

         }

         if(!empty($args['bulding_type_id'])){

            $propertyClass=$propertyClass->where('bulding_type_id',$args['bulding_type_id']);          

         }

        if(!empty($args['filters'])){

            $filters = $args['filters'];
            foreach($filters as $filter){
                $filter_id = $this->getKeyId(Filter::Class,'name',$filter['filter']);
                    $propertyClass=$propertyClass->whereHas('filters_values' , function ($query) use ($filter,$filter_id){
                
                         $query->where(function ($query) use ($filter,$filter_id) {
                            $query->where('filter_id',$filter_id);
                            $query->where('value',$filter['value']);
                        });
                    });
              
           }

        }


      
          $properties = $propertyClass->orderBy('created_at', 'DESC')->get();
         //       $min = 1000;  
         //       $max=2000;
         //  $properties = $properties->filter(function($item) use ($min, $max){
         //   foreach($item->property_deals as $property_deal){
         //      if($property_deal->deal_type_id==1&&$property_deal->price>=$min&&$property_deal->price<=$max){
         //        return true;
         //      }
         //   }

         //   });


         $joinProperties = collect(new Property);

         if(!empty($args['price_filters'])){
       
           foreach($args['price_filters'] as $price_filter){
              $deal_type_id=$this->getKeyId(DealType::Class,'name',$price_filter['deal_type']);
              $propertiesFilters = $properties->filter(function($item) use ($price_filter, $deal_type_id){
                foreach($item->property_deals as $property_deal){
                 if($property_deal->deal_type_id==$deal_type_id){

                    if($property_deal->currency_type_id==$price_filter['currency_type_id']){

                     if(!empty($price_filter['min'])&&!empty($price_filter['max'])){
                       if($property_deal->price>=$price_filter['min']&&$property_deal->price<=$price_filter['max']){
                           return true;
                        }
                     } elseif(!empty($price_filter['max'])){
                        if($property_deal->price<=$price_filter['max']){
                           return true;
                        }
                     }
                      elseif(!empty($price_filter['min'])){
                        if($property_deal->price>=$price_filter['min']){
                           return true;
                        }
                     }  elseif(empty($price_filter['min'])&&empty($price_filter['max'])){

                        return true;

                     }


                     } else {
                        $currency_type_id=$price_filter['currency_type_id'];
                        $price = $this->changeCurrency($property_deal->price,$property_deal->currency_type_id,$currency_type_id);
                      
                        if(!empty($price_filter['min'])&&!empty($price_filter['max'])){
                           if($price>=$price_filter['min']&&$price<=$price_filter['max']){
                             return true;
                           }
                        } elseif(!empty($price_filter['max'])){
                           if($price<=$price_filter['max']){
                              return true;
                           }
                        } elseif(!empty($price_filter['min'])){
                           if($price>=$price_filter['min']){
                              return true;
                           }
                        } elseif(empty($price_filter['min'])&&empty($price_filter['max'])){

                           return true;

                        }

                     } 


                 }
              }
   
              });

              $joinProperties=$joinProperties->merge($propertiesFilters);
           }
           $properties = $joinProperties->unique('id')->sortBy('created_at');

         }





      

 
        return $properties;
  }


  

   
     public function filtersMinMax($propertyClass, $minMax, $filter_name){
   
           $filter_id = $this->getKeyId(Filter::Class,'name', $filter_name);
           $propertyClass=$propertyClass->whereHas('filters_values' , function ($query) use ($minMax,$filter_id){
               $query->where(function ($query) use ($minMax,$filter_id) {
                  $query->where('filter_id',$filter_id);
                  if($minMax['min']){
                     $min = $minMax['min'];
                     $query->whereRaw('CAST (value AS INTEGER) >= ?',  $min);
                   }
                  if($minMax['max']){
                      $max = $minMax['max'];
                       $query->whereRaw('CAST (value AS INTEGER) <= ?', $max);
                   }
              });
          });


          return $propertyClass;
     }
   
     

   

}
