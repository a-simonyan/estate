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
use App\CurrencyType;
use Carbon\Carbon;
use App\Http\Services\PropertyService;

class PropertiesPublishedFilters
{
    use GetIdTrait, ChangeCurrencyTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $total = null;
        $lastPage = null;

        $user = auth('api')->user();

        $propertyClass = Property::with('filters_values');

        if($user){
            $user_id = $user->id;
            $propertyClass->favorite($user_id);
        }

        $propertyClass = $propertyClass->whereNull('deleted_at')
                                       ->whereNull('archived_at')
                                       ->whereNull('saved_at')
                                       ->where('is_public_status','published');

        $propertyClass = $propertyClass->whereHas('user',function($query){
            $query->where('is_delete',false);
            $query->where('is_block',false);
        });

        if(!empty($args['place_rectangle'])){
            $place_rectangle = $args['place_rectangle'];
            $top_left_point = $place_rectangle['top_left_point'];
            $bottom_right_point = $place_rectangle['bottom_right_point'];

            $propertyClass->where('latitude', '<=', $top_left_point['latitude'])
                          ->where('longitude', '>=', $top_left_point['longitude'])
                          ->where('latitude', '>=', $bottom_right_point['latitude'])
                          ->where('longitude', '<=', $bottom_right_point['longitude']);

        }


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
         /*search by with picture*/
         if(!empty($args['with_picture'])){
            $propertyClass = $propertyClass->whereHas('property_images');
         }
        /*search by ids*/
        if(!empty($args['ids'])){
         $propertyClass = $propertyClass->whereIn('properties.id',$args['ids']);
         } 
        /*search by area*/
        if(!empty($args['area'])){
             $minMax = $args['area'];
             $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'area');
         }
        /*search by land_area*/
        if(!empty($args['land_area'])){
            $minMax = $args['land_area'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'land_area');
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
         if(!empty($args['property_height'])){
            $minMax = $args['property_height'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'property_height');
         }
        /*search by number of bathrooms*/
         if(!empty($args['number_of_bathrooms'])){
            $minMax = $args['number_of_bathrooms'];
            $propertyClass = $this->filtersMinMax($propertyClass, $minMax, 'number_of_bathrooms');
         }
        /*search by property state*/
         if(!empty($args['property_state'])){
            $propertyClass=$propertyClass->where('property_state',$args['property_state']);
         }
        /*search by region*/
        if(!empty($args['region'])){
            $propertyClass=$propertyClass->where('region','ilike', '%'.$args['region'].'%');
        }
        /*search by bulding type*/
         if(!empty($args['bulding_type_id'])){
            $propertyClass=$propertyClass->where('bulding_type_id',$args['bulding_type_id']);
         }
         if(!empty($args['land_area_type_id'])){
            $propertyClass=$propertyClass->where('land_area_type_id',$args['land_area_type_id']);
         }
         /*search by deal type*/
         if(!empty($args['deal_types'])){
            $deal_types=$args['deal_types'];
            $propertyClass = $propertyClass->whereHas('deal_types' , function ($query) use ($deal_types){
               $query->whereIn('name',$deal_types);
            });
         }
        /*search by is_negotiable*/
        if(isset($args['is_negotiable'])&&!$args['is_negotiable']){
            $propertyClass = $propertyClass->whereHas('property_deals' , function ($query){
                $query->whereNull('price');
            },0);
        }


        /*search by filters value*/
        if(!empty($args['filters'])){
            if(empty($args['deal_types'])||count($args['deal_types'])>1){
               $filterDealTypes = ['sell', 'rent'];
            } elseif(!empty($args['deal_types'][0])&&$args['deal_types'][0]=='sale') {
               $filterDealTypes = ['sell'];
            } elseif(!empty($args['deal_types'][0])&&($args['deal_types'][0]=='monthly_rental_fee'||$args['deal_types'][0]=='daily_rental_fee')){
               $filterDealTypes = ['rent'];
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


        if(empty($args['place']) && empty($args['address']) && empty($args['price_filters']) && empty($args['price_order']) && !empty($args['paginate'])){
            $first = !empty($args['paginate']['first']) ? $args['paginate']['first'] : 10;
            $page  = !empty($args['paginate']['page']) ? $args['paginate']['page'] : 1;

            $properties = $propertyClass->orderBy('is_top', 'DESC')->orderBy('last_update', 'DESC')->paginate($first,['*'],'page', $page);
          
            $total = $properties->total();
            $lastPage = $properties->lastPage(); 

            return ['properties' => $properties, 'total' => $total, 'lastPage' => $lastPage];


        }
        if(!empty($args['place']) || empty($args['address'])){
           /* order by created date*/
           $properties = $propertyClass->orderBy('is_top', 'DESC')->orderBy('last_update', 'DESC')->get();
        }
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

          } elseif(!empty($args['address'])){
            
            /*search by address*/
           $address = $args['address'];
           $propertyClass = $propertyClass
            ->whereHas('translate_property_address',function($query) use ($address){
               $query->where('addresse','ilike', '%'.$address.'%');
            })->orderBy('last_update', 'DESC')->get();

            $properties =  $propertyClass;

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


          /*order by price  ASC and DESC*/
          if(!empty($args['price_order'])){
              $currency_type_id = CurrencyType::where('is_current',true)->first()->id;
              $propertie_plus = [];
              $propertie_minus = [];
              $price_order=$args['price_order'];

              if(!empty($args['price_filters']) && count($args['price_filters'])){
                  $price_filter =  $args['price_filters'][0];
                       foreach($properties as $propertie){
                          $deal_type_id=$this->getKeyId(DealType::Class,'name',$price_filter['deal_type']);
                          foreach($propertie->property_deals as $property_deal){
                              if($property_deal->deal_type_id==$deal_type_id){
                                  $propertie->price_order = $this->changeCurrency($property_deal->price,$property_deal->currency_type_id,$currency_type_id);
                                  break;
                              }
                          }
                           $propertie->price_order = !empty($propertie->price_order) ? $propertie->price_order : 0;
                           $propertie_plus[]=$propertie;
                       }

             } elseif(empty($args['price_filters'])){
                  $deal_type_id=$this->getKeyId(DealType::Class,'name','sale');
                  foreach($properties as $propertie){
                      foreach($propertie->property_deals as $property_deal){
                          if($property_deal->deal_type_id==$deal_type_id){
                              $propertie->price_order = $this->changeCurrency($property_deal->price,$property_deal->currency_type_id,$currency_type_id);
                              break;
                          }
                      }
                      if(empty($propertie->price_order) && !empty($propertie->property_deals[0])){
                          $property_deal = $propertie->property_deals[0];
                          $propertie->price_order = -$this->changeCurrency($property_deal->price,$property_deal->currency_type_id,$currency_type_id);

                          $propertie_minus[]=$propertie;

                      } else {
                          $propertie_plus[]=$propertie;
                      }

                  }
              }

              $propertie_plus  = collect($propertie_plus);
              $propertie_minus = collect($propertie_minus);

              if( $price_order == 'DESC') {
                  $propertie_plus  = $propertie_plus->sortByDesc('price_order');
                  $propertie_minus = $propertie_minus->sortBy('price_order'); 
                  $properties = $propertie_plus->merge($propertie_minus);
              } else {
                 $propertie_plus  = $propertie_plus->sortBy('price_order');
                 $propertie_minus = $propertie_minus->sortByDesc('price_order'); 
                 $properties = $propertie_plus->merge($propertie_minus);
              }

              if(!empty($args['latest'])){
                   $properties = $properties->sortByDesc(function($element) {
                    return Carbon::parse($element->last_update)->format('d');
                   });
               } 


          }

       /*add paginate*/
       if(!empty($args['paginate'])){
           $first = !empty($args['paginate']['first']) ? $args['paginate']['first'] : 10;
           $page  = !empty($args['paginate']['page']) ? $args['paginate']['page'] : 1;

           $properties =  PropertyService::paginate($properties, $first, $page);
           $total = $properties->total();
           $lastPage = $properties->lastPage();

           return ['properties' => $properties, 'total' => $total, 'lastPage' => $lastPage];
       }


       return ['properties' => $properties, 'total' => $total, 'lastPage' => $lastPage];
  }

   
  public function filtersMinMax($propertyClass, $minMax, $filter_name){
   
           $filter_id = $this->getKeyId(Filter::Class,'name', $filter_name);
           $propertyClass=$propertyClass->whereHas('filters_values' , function ($query) use ($minMax,$filter_id){
               $query->where(function ($query) use ($minMax,$filter_id) {
                  $query->where('filter_id',$filter_id);
                  if($minMax['min']){
                     $min = $minMax['min'];
                     $query->whereRaw('CAST (value AS DOUBLE PRECISION) >= ?',  $min);
                   }
                  if($minMax['max']){
                      $max = $minMax['max'];
                       $query->whereRaw('CAST (value AS DOUBLE PRECISION) <= ?', $max);
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
