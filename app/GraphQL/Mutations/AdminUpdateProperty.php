<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\DealType;
use App\Filter;
use App\Property;
use App\PropertyImage;
use App\PropertyType;
use App\FiltersValue;
use App\TranslateDescription;
use App\PropertyDeal;
use App\Language;
use App\PropertyAttachPhone;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use App\Exceptions\SendException;
use App\Events\PropertyPublished;
use App\Http\Traits\GetIdTrait;
use Image;
use Carbon\Carbon;
use App\NotificationUsersProperties;
use App\UserFavoriteProperty;
use App\Http\Services\PropertyService;



class AdminUpdateProperty
{
    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $property_id = $args['id'];

        $property = Property::find($property_id);

        if($property){
            $array_property = [];
            if(!empty($args['public_status'])){
                $array_property['is_public_status'] = $args['public_status'];
               if($property->is_public_status!="published" && $args['public_status']=="published"){
                  $this->checkSamePlace($property); 
                  event( new PropertyPublished($property_id) );
               }
               $nextUpdateDaysCount = env('Next_UPDATE_DAYS_COUNT',1);
               $array_property['last_update'] = Carbon::now();
               $array_property['next_update'] = Carbon::now()->addDays($nextUpdateDaysCount);
            }
            if(!empty($args['review'])){
                $array_property['review'] = $args['review'];
            }
            if(isset($args['is_delete'])){
                $array_property['deleted_at'] = $args['is_delete'] ? Carbon::now() : null;

                if($args['is_delete']){
                    $this->deletePropertyAllConnection($property_id);
                }
            }
            if(isset($args['is_archive'])){
                $array_property['archived_at'] = $args['is_archive'] ? Carbon::now() : null;
                if(!$array_property['archived_at']){
                    $array_property['last_update'] = Carbon::now();
                }
            }   
            if(!empty($args['property_key'])){
                $array_property['property_key'] = $args['property_key'];
            }
            if(!empty($args['property_type'])){
                $array_property['property_type_id'] = $this->getKeyId(PropertyType::Class,'name',$args['property_type']);
            }
            if(!empty($args['bulding_type_id'])){
                $array_property['bulding_type_id'] = $args['bulding_type_id'];
            }
            if(!empty($args['land_area_type_id'])){
                $array_property['land_area_type_id'] = $args['land_area_type_id'];
            }
            if(!empty($args['latitude'])){
                $array_property['latitude'] = $args['latitude'];
            }
            if(!empty($args['longitude'])){
                $array_property['longitude'] = $args['longitude'];
            }
            if(!empty($args['address'])){
                $array_property['address'] = $args['address'];
            }
            if(!empty($args['region'])){
                $array_property['region'] = $args['region'];
            }
            if(!empty($args['postal_code'])){
                $array_property['postal_code'] = $args['postal_code'];
            }
            if(!empty($args['property_state'])){
                $array_property['property_state'] = $args['property_state'];
            }
            if(!empty($args['email'])){
                $array_property['email'] = $args['email'];
            }
            if(isset($args['is_bids'])){
                $array_property['is_bids'] = $args['is_bids'];
            }
            if(isset($args['is_address_precise'])){
                $array_property['is_address_precise'] = $args['is_address_precise'];
            }
            $property->update($array_property);


            if(!empty($args['property_deal_types'])){
                $this->savePropertyDealTypes($property_id, $args['property_deal_types']);
            }
            if(!empty($args['property_images'])){
                $this->savePropertyImages($property_id,$args['property_images']);
            }
            if(!empty($args['phone'])){
                PropertyAttachPhone::where('property_id',$property_id)->delete();
                $this->savePhone($property->user,$property_id,$args['phone']);
            }

            if(!empty($args['property_images_delete_ids'])){
                $this->deletePropertyImages($args['property_images_delete_ids']);
            }

            if(!empty($args['property_filter_values'])){
                $this->savePropertyFilterValues($property_id, $this->getKeyId(PropertyType::Class,'name',$args['property_type']), $args['property_filter_values']);
            }
            if(!empty($args['translate_descriptions'])){
                $this->saveTranslateDescription($property_id, $args['translate_descriptions']);
            }
            if(!empty($args['longitude'])&&!empty($args['latitude'])){
                PropertyService::getAndSaveTranslatePropertyAddress($property_id, $args['longitude'].','.$args['latitude']);
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
                'property_id'       => $property_id,
                'deal_type_id'      => $this->getKeyId(DealType::Class,'name',$property_deal_type['deal_type']),
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

                    $image = Image::make(storage_path('app/public/property/'.$fileName_img));

                    $image->resize(null, 200, function($constraint) {
                        $constraint->aspectRatio();
                    });
            
                    $image->save(storage_path('app/public/property/min/'.$fileName_img));

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

    public function deletePropertyImages($property_images_delete_ids){

        foreach($property_images_delete_ids as $images_id){
            $propertyImage=PropertyImage::find($images_id);
            if($propertyImage){
                $propertyImage_name = $propertyImage->getRawOriginal('name');
                if($propertyImage_name&&file_exists(storage_path('app/public/property/'.$propertyImage_name))){
                    unlink(storage_path('app/public/property/'. $propertyImage_name));
                }
                if($propertyImage_name&&file_exists(storage_path('app/public/property/min/'.$propertyImage_name))){
                    unlink(storage_path('app/public/property/min/'.$propertyImage_name));
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
                $deal_type = !empty($property_filter_value['deal_type']) ? $property_filter_value['deal_type'] : null;
                $filter = Filter::where('name', $property_filter_value['filter'])
                                 ->where('deal_type',  $deal_type)
                                 ->first();
                if($filter){
                    $filter_id = $filter->id;
                    FiltersValue::where('filter_id',$filter_id)->where('property_id',$property_id)
                                ->update(['value' => !empty($property_filter_value['value']) ? $property_filter_value['value'] : NULL ]);
                }        
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

    public function deletePropertyAllConnection($property_id){
        if($property_id){
            NotificationUsersProperties::where('property_id',$property_id)->delete();
            UserFavoriteProperty::where('property_id',$property_id)->delete();
        }
    }

    public function checkSamePlace(Property $property){
        $count = Property::where('is_public_status','published')
                         ->whereNull('deleted_at')
                         ->whereNull('archived_at')
                         ->whereNull('saved_at')
                         ->where('latitude', $property->latitude)
                         ->where('longitude', $property->longitude)
                         ->update(['same_place_group' => $property->latitude.','.$property->longitude]);
         
        if($count){
            $property->update(['same_place_group' => $property->latitude.','.$property->longitude]);
        } elseif($property->same_place_group){
            $property->update(['same_place_group' => null]);
        }        
    }


    public function savePhone($user_auth,$property_id,$phone){
        if(!empty($phone['attach_phones'])){

            foreach($phone['attach_phones'] as $key){
               $userPhones = $user_auth->phones;
               $attachPhone = $userPhones->where('id',$key)->first();
               if($attachPhone){
                   PropertyAttachPhone::create([
                       'code'        => $attachPhone->code,
                       'number'      => $attachPhone->number,
                       'viber'       => $attachPhone->viber,
                       'whatsapp'    => $attachPhone->whatsapp,
                       'telegram'    => $attachPhone->telegram,
                       'property_id' => $property_id
                   ]);
               }
            }
        }
        if(!empty($phone['new_phones'])){
           foreach($phone['new_phones'] as $newPhone){
               PropertyAttachPhone::create([
                   'code'        => $newPhone['code'],
                   'number'      => $newPhone['number'],
                   'viber'       => !empty($newPhone['viber']) ? $newPhone['viber'] : false,
                   'whatsapp'    => !empty($newPhone['whatsapp']) ? $newPhone['whatsapp'] : false,
                   'telegram'    => !empty($newPhone['telegram']) ? $newPhone['telegram'] : false,
                   'property_id' => $property_id
               ]);
           }


        }

        return true;

   }

}
