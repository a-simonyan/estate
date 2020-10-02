<?php

namespace App\GraphQL\Mutations;
use App\Property;
use App\PropertyImage;
Use App\PropertyType;
use App\FiltersValue;
use App\TranslateDescription;
use App\PropertyDeal;
use App\Language;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\PlaceTrait;


class CreateProperty
{
    use PlaceTrait;

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {


        $user_id = Auth::user()->id;

        
        $property = Property::create(['property_type_id' => $args['property_type_id'],
                                      'user_id'          => $user_id,  
                                      'property_number'  => $args['property_number'],
                                      'bulding_type_id'  => $args['bulding_type_id'],
                                      'latitude'         => $args['latitude'],
                                      'longitude'        => $args['longitude'],
                                      'country_id'       => $this->countryId($args['country']),
                                      'city_id'          => $this->cityId($args['city']),
                                      'address'          => $args['address'],
                                      'postal_code'      => $args['postal_code'],
                                      'property_state'   => $args['property_state'],
                                     ]); 

        if($property){                             
                                  
             $property_id=$property->id;

             if(!empty($args['property_deal_types'])){
               $this->savePropertyDealTypes($property_id, $args['property_deal_types']);
             }
             if(!empty($args['property_images'])){
               $this->savePropertyImages($property_id,$args['property_images']);
             }
             if(!empty($args['property_filter_values'])){
               $this->savePropertyFilterValues($property_id, $args['property_type_id'], $args['property_filter_values']);
             }
             if(!empty($args['translate_descriptions'])){
               $this->saveTranslateDescription($property_id, $args['translate_descriptions']);
             }
    
           

        }
        return  $property;
    }

    public function savePropertyDealTypes($property_id, $property_deal_types){

         foreach($property_deal_types as $property_deal_type){
            PropertyDeal::create([
                'property_id'   => $property_id,
                'deal_type_id'  => $property_deal_type['deal_type_id'],
                'price'         => $property_deal_type['price']
            ]);
         }

    }



    public function savePropertyImages($property_id,$property_images){

      if($property_images){
        $image_types = ["jpeg","jpg","png"];

        foreach($property_images as $property_image){
            $picture_type=$property_image['type'];
            
            if (in_array($picture_type, $image_types)){
                $image = $property_image['image'];
                 
                $imageName = Str::random(10).time().'.'.$picture_type;
                while(file_exists(storage_path('app/public/property/'.$imageName))){
                    $imageName = Str::random(10).time().$picture_type;
                };
                Storage::put('public/property/'.$imageName, base64_decode($image));
                if(file_exists(storage_path('app/public/property/'.$imageName))){
                    PropertyImage::create([
                        'property_id' => $property_id,
                        'name'        => $imageName
                    ]);
                }

            } 

        }
      }
        return true;

    }

    public function savePropertyFilterValues($property_id, $property_type_id, $property_filter_values){

        $property_type_filters = PropertyType::find($property_type_id)->filters;
    
    
        if($property_type_filters){
            foreach($property_type_filters as $property_type_filter){
                FiltersValue::create([
                    'filter_id'   => $property_type_filter->id,
                    'property_id' => $property_id
                ]);
            }
        }
        if($property_filter_values){
           foreach($property_filter_values as $property_filter_value){
               FiltersValue::where('filter_id',$property_filter_value['filter_id'])->update(['value' => $property_filter_value['value']]);
           }
        }
         
        return true;

    }

    public function saveTranslateDescription($property_id,$translate_descriptions){

         if($translate_descriptions){

            foreach($translate_descriptions as $translate_description){
                $language_code = $translate_description['language'];
                $language = Language::where('code',$language_code)->first();
                if($language){
                    $language_id = $language->id;
                    TranslateDescription::create([
                      'property_id' => $property_id,
                      'language_id' => $language_id,
                      'description' => $translate_description['description']
                    ]);

                }

            }


         }

         return true;


    }




}
