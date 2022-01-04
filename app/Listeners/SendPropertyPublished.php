<?php

namespace App\Listeners;

use App\Events\PropertyPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\SaveUserFilter;
use App\UserType;
use App\Property;
use App\Filter;
use App\PropertyType;
use App\PropertyDeal;
use App\DealType;
use DB;
use App\Http\Traits\GetIdTrait;
use App\Http\Traits\ChangeCurrencyTrait;
use App\CurrencyType;

use App\NotificationUsersProperties;
use App\Events\PropertyNotification;

use Storage;


class SendPropertyPublished implements ShouldQueue
{
    use GetIdTrait, ChangeCurrencyTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PropertyPublished  $event
     * @return void
     */
    public function handle(PropertyPublished $event)
    {
      
        $property_id = $event->property_id;


        $saveUserFilters = SaveUserFilter::all();

        foreach($saveUserFilters as $saveUserFilter){
            $properties_filters = json_decode($saveUserFilter->properties_filters,true);

            $property = $this->check_filters($property_id,$properties_filters);

            if(count($property)){
              
                NotificationUsersProperties::create([
                    'user_id'     => $saveUserFilter->user_id,
                    'property_id' => $property_id
                ]);

                event( new PropertyNotification($saveUserFilter->user_id,['property'=>$property]) );
            };

        }

       
        Storage::put('file.txt', 'add-'.$property_id);
       
    }

    public function check_filters($property_id, $args){



        $propertyClass = Property::with('filters_values','property_images')->where('id',$property_id);
        $propertyClass = $propertyClass->where('is_delete', false)
                                       ->where('is_archive', false)
                                       ->where('is_public_status','published');

        $propertyClass = $propertyClass->whereHas('user',function($query){
            $query->where('is_delete',false);
            $query->where('is_block',false);
        });

        /*search by property type*/
        if(!empty($args['property_type'])){
         $typeArr=[];
         foreach($args['property_type'] as $property_type){
            $property_type_id = $this->getKeyId(PropertyType::Class,'name',$property_type);
            array_push($typeArr,$property_type_id);
         }
        
         $propertyClass = $propertyClass->whereIn('property_type_id',$typeArr);
       }
          /*search by user type*/
          if(!empty($args['user_type'])){
            $user_type_id = $this->getKeyId(UserType::Class,'name',$args['user_type']);
            $propertyClass = $propertyClass->whereHas('user',function ($query) use ($user_type_id){
                                                         $query->where('user_type_id',$user_type_id);
                                                      });
          }
        /*search by area*/
        if(!empty($args['area'])){
             $minMax = $args['area'];
             $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'area');
          }
        /*search by number of floors of the building*/
        if(!empty($args['number_of_floors_of_the_building'])){
            $minMax = $args['number_of_floors_of_the_building'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'number_of_floors_of_the_building');
        }
        /*search by apartment floor*/
         if(!empty($args['apartment_floor'])){
            $minMax = $args['apartment_floor'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'apartment_floor');
         }
        /*search by number of rooms*/
         if(!empty($args['number_of_rooms'])){
            $minMax = $args['number_of_rooms'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'number_of_rooms');
         }
        /*search by number of bathrooms*/
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
        /*search by property state*/
         if(!empty($args['property_state'])){
            $propertyClass=$propertyClass->where('property_state',$args['property_state']);
         }
        /*search by bulding type*/
         if(!empty($args['bulding_type_id'])){
            $propertyClass=$propertyClass->where('bulding_type_id',$args['bulding_type_id']);
         }
         /*search by deal type*/
         if(!empty($args['deal_types'])){
            $deal_types=$args['deal_types'];
            $propertyClass = $propertyClass->whereHas('deal_types' , function ($query) use ($deal_types){
               $query->whereIn('name',$deal_types);
            });
         }


        /*search by filters value*/
        if(!empty($args['filters'])){
            if(empty($args['deal_types'])||count($args['deal_types'])>1){
               $filterDealTypes = ['sell', 'rent'];
            } elseif(!empty($args['deal_types'][0])&&$args['deal_types'][0]=='sale') {
               $filterDealTypes = ['sell'];
            } elseif(!empty($args['deal_types'][0])&&($args['deal_types'][0]=='monthly_rental_fee'||$args['deal_types'][0]=='daily_rental_fee')){
               $filterDealTypes = ['rent'];
            } else {
               $filterDealTypes = ['sell', 'rent'];
            }

            $filters = $args['filters'];
            foreach($filters as $filter){
               $filter_ids = Filter::where('name',$filter['filter'])
               ->where(function ($query) use ($filterDealTypes) {
                            $query->whereIn('deal_type', $filterDealTypes);
                            $query->orWhereNull('deal_type');
                })
               ->pluck('id');
               $propertyClass = $propertyClass->whereHas('filters_values' , function ($query) use ($filter,$filter_ids){
                                    $query->where(function ($query) use ($filter,$filter_ids) {
                                          $query->whereIn('filter_id',$filter_ids);
                                          $query->where('value',$filter['value']);
                                    });
               });
           }
        }


        if(empty($args['place']) && empty($args['price_filters'])){
            return $propertyClass->get();
        }
       /* order by created date*/
       $properties = $propertyClass->get();
       /*search by place*/
        if(!empty($args['place'])){
            $places = $args['place'];
            foreach($places as $key => $place){

                    $plaseModel = $propertyClass ; 
                    $radius = empty($place['radius']) ? 5 : $place['radius'];
                    $plaseModel = $plaseModel->from(DB::raw("(select *,
                       ( 6371 * acos( cos( radians(".$place['latitude'].") ) *
                           cos( radians( latitude) )
                           * cos( radians( longitude ) - radians(".$place['longitude'].")
                           ) + sin( radians(".$place['latitude'].") ) *
                           sin( radians( latitude ) ) )
                       ) AS distance from properties) as properties"))
                       ->groupBy(DB::raw('id, property_key,property_type_id, user_id, bulding_type_id, latitude, longitude, address, postal_code ,property_state, review, is_public_status, is_save, is_delete, created_at, updated_at, email, is_address_precise, view, update_count, last_update, next_update, is_archive, is_bids,  distance'))
                       ->orderBy("distance")
                       ->get();
                   
                   $plaseModel = $plaseModel->where("distance", "<", $radius);
                   if(!$key){
                      $merge_place = $plaseModel;
                    } else {
                      $merge_place = $merge_place->merge( $plaseModel);
                    }
             }
             $propertyClass = $merge_place;
             $properties = $merge_place->unique('id');
          }

        /*search by price and deal type*/
         if(!empty($args['price_filters'])){
            $joinProperties = collect(new Property);
       
           foreach($args['price_filters'] as $price_filter){
              $deal_type_id=$this->getKeyId(DealType::Class,'name',$price_filter['deal_type']);
              $propertiesFilters = $properties->filter(function($item) use ($price_filter, $deal_type_id){
                foreach($item->property_deals as $property_deal){
                 if($property_deal->deal_type_id==$deal_type_id){
                    if(!empty($price_filter['currency_type_id'])&&$property_deal->currency_type_id==$price_filter['currency_type_id']){
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

                     } elseif(!empty($price_filter['currency_type_id'])){
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

                     } else {
                        return true;
                    }

                 }
              }
   
              });

              $joinProperties=$joinProperties->merge($propertiesFilters);
           }
           $properties = $joinProperties->unique('id')->sortBy('last_update');
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
                 //  if($minMax['min']){
                  //    $min = $minMax['min'];
                  //    $query->whereRaw('CONVERT(value , UNSIGNED) >= ?',  $min);
                  //  }
                  // if($minMax['max']){
                  //     $max = $minMax['max'];
                  //      $query->whereRaw('CONVERT(value , UNSIGNED) <= ?', $max);
                  //  }
           });
       });


       return $propertyClass;
    }

  

    


}
