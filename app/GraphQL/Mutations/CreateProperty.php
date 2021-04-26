<?php

namespace App\GraphQL\Mutations;
use App\DealType;
use App\Filter;
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
use App\Http\Traits\GetIdTrait;


class CreateProperty
{


    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {


        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;

        if(empty($args['property_id'])){

            $property = Property::create(['property_key'     => !empty($args['property_key'])? $args['property_key'] : null,
                                          'property_type_id' => $this->getKeyId(PropertyType::Class,'name',$args['property_type']),
                                          'user_id'          => $user_id,  
                                          'bulding_type_id'  => $args['bulding_type_id'],
                                          'latitude'         => $args['latitude'],
                                          'longitude'        => $args['longitude'],
                                          'address'          => $args['address'],
                                          'postal_code'      => !empty($args['postal_code'])? $args['postal_code'] : null,
                                          'property_state'   => !empty($args['property_state'])? $args['property_state'] : null,
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
                   $this->savePropertyFilterValues($property_id, $this->getKeyId(PropertyType::Class,'name',$args['property_type']), $args['property_filter_values']);
                 }
                 if(!empty($args['translate_descriptions'])){
                   $this->saveTranslateDescription($property_id, $args['translate_descriptions']);
                 }
        
               
    
            }

        } else {

            $property = Property::Find($args['property_id']);

            if($property){
                $property->update(
                   ['property_key'     => !empty($args['property_key'])? $args['property_key'] : null,
                    'property_type_id' => $this->getKeyId(PropertyType::Class,'name',$args['property_type']),
                    'user_id'          => $user_id,  
                    'bulding_type_id'  => $args['bulding_type_id'],
                    'latitude'         => $args['latitude'],
                    'longitude'        => $args['longitude'],
                    'address'          => $args['address'],
                    'postal_code'      => !empty($args['postal_code'])? $args['postal_code'] : null,
                    'property_state'   => !empty($args['property_state'])? $args['property_state'] : null,
                    'is_save'          => false   
                   ]
                );

            }


            $property_id=$property->id;
    
            if(!empty($args['property_deal_types'])){
                PropertyDeal::where('property_id',$property_id)->delete();  
                $this->savePropertyDealTypes($property_id, $args['property_deal_types']);
            }
            if(!empty($args['property_images'])){
                $this->savePropertyImages($property_id,$args['property_images']);
            }
            if(!empty($args['property_filter_values'])){
                FiltersValue::where('property_id',$property_id)->delete();
                $this->savePropertyFilterValues($property_id, $this->getKeyId(PropertyType::Class,'name',$args['property_type']), $args['property_filter_values']);
            }
            if(!empty($args['translate_descriptions'])){
                TranslateDescription::where('property_id',$property_id)->delete(); 
                $this->saveTranslateDescription($property_id, $args['translate_descriptions']);
            };
            if(!empty($args['property_images_delete_ids'])){
                $this->deletePropertyImages($user_auth, $args['property_images_delete_ids']);
            }



        }





        return  $property;
    }

    public function savePropertyDealTypes($property_id, $property_deal_types){

         foreach($property_deal_types as $property_deal_type){
            PropertyDeal::create([
                'property_id'       => $property_id,
                'deal_type_id'      => $this->getKeyId(DealType::Class,'name',$property_deal_type['deal_type']) ,
                'price'             => $property_deal_type['price'],
                'currency_type_id'  => $property_deal_type['currency_type_id'],
            ]);
         }

    }



    public function savePropertyImages($property_id,$property_images){

      if($property_images){

        $propertyImage=PropertyImage::where('property_id',$property_id)->orderBy('index','desc')->first();

        if($propertyImage){
            $index = $propertyImage->index + 1;
        } else {
            $index = 1;
        }

        foreach($property_images as $property_image){
                
                $fileName_img = Str::random(10).time().'.'.$property_image->getClientOriginalExtension();
                while(file_exists(storage_path('app/public/property/'.$fileName_img))){
                    $fileName_img = Str::random(10).time().'.'.$property_image->getClientOriginalExtension();
                };
                $property_image->storeAs('public/property',$fileName_img);
                if(file_exists(storage_path('app/public/property/'.$fileName_img))){
                    PropertyImage::create([
                        'property_id' => $property_id,
                        'name'        => $fileName_img,
                        'index'       => $index++
                    ]);
                }
        }
        
      }
        return true;

    }


    public function deletePropertyImages($user_auth, $property_images_delete_ids){

        foreach($property_images_delete_ids as $images_id){
           $propertyImage=PropertyImage::find($images_id);
           if($user_auth->id == $propertyImage->property->user_id){
               $propertyImage_name = $propertyImage->getOriginal('name');

               if($propertyImage_name&&file_exists(storage_path('app/public/property/'.$propertyImage_name))){
                   unlink(storage_path('app/public/property/'.$propertyImage_name));
                 }
                 $propertyImage->delete();
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
               
               $filter_id = $this->getKeyId(Filter::Class,'name',$property_filter_value['filter']);
               FiltersValue::where('filter_id',$filter_id)->update(['value' => $property_filter_value['value']]);
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
