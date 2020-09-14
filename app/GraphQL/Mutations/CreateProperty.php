<?php

namespace App\GraphQL\Mutations;
use App\Property;
use App\PropertyImage;
Use App\PropertyType;
use FiltersValue;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CreateProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {

        $user_id = Auth::user()->id;

        
        $property = Property::create(['property_type_id' => $args['property_type_id'],
                                      'user_id'          => $user_id,  
                                      'deal_type_id'     => $args['deal_type_id'],
                                      'property_number'  => $args['property_number'],
                                      'bulding_type_id'  => $args['bulding_type_id'],
                                      'latitude'         => $args['latitude'],
                                      'longitude'        => $args['longitude'],
                                      'country_id'       => $args['country_id'],
                                      'city_id'          => $args['city_id'],
                                      'address'          => $args['address'],
                                      'postal_code'      => $args['postal_code'],
                                     ]); 

        if($property){                             
                                  
             $property_id=$property->id;
    
             if($args['property_images']){
    
                 $property_images=$args['property_images'];
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
    
             $property_type_filters = PropertyType::find($args['property_type_id'])->filters;
    
    
             if($property_type_filters){
                 foreach($property_type_filters as $property_type_filter){
                     FiltersValue::create([
                         'filter_id'=>$property_type_filter->id,
                         'property_id' => $property_id
                     ]);
                 }
             }
             if($args['property_filter_values']){
                $property_filter_values = $args['property_filter_values'];
                foreach($property_filter_values as $property_filter_value){
                    FiltersValue::where('filter_id',$property_filter_value['filter_id'])->update(['value' => $property_filter_value['value']]);
                }
                 
             }
    

        }
        return  $property;
    }
}
