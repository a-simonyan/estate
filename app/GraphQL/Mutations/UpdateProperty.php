<?php

namespace App\GraphQL\Mutations;
use Auth;
use App\Property;
use App\PropertyImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use App\Exceptions\SendException;
use App\Http\Traits\PlaceTrait;


class UpdateProperty
{
    use PlaceTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     =  $user_auth->id;
        $property_id = $args['id'];


         $property = Property::Find($property_id);                            

        if($property&&$user_auth->is_admin||$property->user->id == $user_id){      
            $array_property = [];   
            
            if(!empty($args['property_type_id'])){
                $array_property['property_type_id'] = $args['property_type_id'];
            }
            if(!empty($args['property_number'])){
                $array_property['property_number'] = $args['property_number'];
            }
            if(!empty($args['bulding_type_id'])){
                $array_property['bulding_type_id'] = $args['bulding_type_id'];
            }
            if(!empty($args['latitude'])){
                $array_property['latitude'] = $args['latitude'];
            }
            if(!empty($args['longitude'])){
                $array_property['longitude'] = $args['longitude'];
            }
            if(!empty($args['country'])){
                $array_property['country_id'] = $this->countryId($args['country']);
            }
            if(!empty($args['city'])){
                $array_property['city_id'] = $this->cityId($args['city']);
            }
            if(!empty($args['address'])){
                $array_property['address'] = $args['address'];
            }
            if(!empty($args['postal_code'])){
                $array_property['postal_code'] = $args['postal_code'];
            }
            if(!empty($args['property_state'])){
                $array_property['property_state'] = $args['property_state'];
            }
           
            $property->update($array_property);


             if(!empty($args['property_deal_types'])){
               $this->savePropertyDealTypes($property_id, $args['property_deal_types']);
             }
             if(!empty($args['property_images'])){
               $this->savePropertyImages($property_id,$args['property_images']);
             }

             if(!empty($args['property_images_delete_ids'])){
                $this->deletePropertyImages($user_auth, $args['property_images_delete_ids']);
             }

             if(!empty($args['property_filter_values'])){
               $this->savePropertyFilterValues($property_id, $args['property_type_id'], $args['property_filter_values']);
             }
             if(!empty($args['translate_descriptions'])){
               $this->saveTranslateDescription($property_id, $args['translate_descriptions']);
             }
    
            return  $property;
           

        } else {

            throw new SendException(
                'error',
                __('messages.not_have_permission')
              );
        }


    }
    


    public function savePropertyDealTypes($property_id, $property_deal_types){
       
        if($property_deal_types){
           PropertyDeal::where('property_id',$property_id)->delete();
        }

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

   public function deletePropertyImages($user_auth, $property_images_delete_ids){

     foreach($property_images_delete_ids as $images_id){
        $propertyImage=PropertyImage::find($images_id);
        if($user_auth->is_admin||$user_auth->id == $propertyImage->property->user_id){
            if($propertyImage->name&&file_exists(storage_path('app/public/property/'.$propertyImage->name))){
                unlink(storage_path('app/public/property/'.$propertyImage->name));
              }
              $propertyImage->delete();
        }

     }

    return true;

   }


   public function savePropertyFilterValues($property_id, $property_type_id, $property_filter_values){

       if($property_filter_values){

          FiltersValue::where('property_id',$property_id)->update(['value' => null]);

          foreach($property_filter_values as $property_filter_value){
              FiltersValue::where('filter_id',$property_filter_value['filter_id'])->update(['value' => $property_filter_value['value']]);
          }
       }
        
       return true;

   }

   public function saveTranslateDescription($property_id,$translate_descriptions){

        if($translate_descriptions){
            TranslateDescription::where('property_id',$property_id)->delete();

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
