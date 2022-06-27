<?php

namespace App\GraphQL\Mutations;


use Auth;
use App\Property;
use App\PropertyImage;
use App\FiltersValue;
use App\TranslateDescription;
use App\PropertyDeal;
use App\PropertyAttachPhone;
use Illuminate\Support\Str;
use App\Exceptions\SendException;
use Image;
use Carbon\Carbon;
use File;


class CopySaveProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;
        $property_id = $args['id'];

        $property = Property::Find($property_id);

        if($property&&$property->saved_at&&!$property->deleted_at&&$property->user->id == $user_id){

            $newProperty = $property->replicate();
            $newProperty->created_at = Carbon::now();
            $newProperty->updated_at = Carbon::now();
            $newProperty->saved_at = Carbon::now();
            $newProperty->copy_id = $property_id;
            $newProperty->save();

            $newProperty_id = $newProperty->id;

            $this->copyPropertyDealTypes($newProperty_id, $property->property_deals);
            $this->copyPropertyImages($newProperty_id, $property->property_images);
            $this->copyPropertyFilterValues($newProperty_id,$property->filters_values);
            $this->copyTranslateDescription($newProperty_id,$property->translate_descriptions);
            $this->savePhone($newProperty_id, $property->property_attach_phones);


            return $newProperty;

        } else {

                throw new SendException(
                    'error',
                    __('messages.not_have_permission')
                );

        }

    }




    public function copyPropertyDealTypes($property_id, $property_deals){

        if(!empty($property_deals)) {
            foreach ($property_deals as $property_deal) {
                PropertyDeal::create([
                    'property_id' => $property_id,
                    'deal_type_id' => $property_deal->deal_type_id,
                    'price' => $property_deal->price,
                    'currency_type_id' => $property_deal->currency_type_id,
                ]);
            }
        }

    }



    public function copyPropertyImages($property_id,$property_images){

        if(!empty($property_images)){

            foreach($property_images as $property_image){
                $img = $property_image->getRawOriginal('name');
                if(file_exists(storage_path('app/public/property/'.$img))){
                    $fileName_img = $property_id.'_'.$img;

                    while(file_exists(storage_path('app/public/property/'.$fileName_img))){
                        $fileName_img = Str::random(3).'.'.$fileName_img;
                    };

                    File::copy(storage_path('app/public/property/'.$img), storage_path('app/public/property/'.$fileName_img));
                    if(file_exists(storage_path('app/public/property/min/'.$img))) {
                        File::copy(storage_path('app/public/property/min/'.$img), storage_path('app/public/property/min/'.$fileName_img));
                    }

                    PropertyImage::create([
                        'property_id' => $property_id,
                        'name'        => $fileName_img,
                        'index'       => $property_image->index
                    ]);

                }

            }
        }
        return true;

    }



    public function copyPropertyFilterValues($property_id, $property_filter_values){

        if(!empty($property_filter_values)){
            foreach($property_filter_values as $property_filter_value){
                FiltersValue::create([
                    'filter_id'   => $property_filter_value->filter_id,
                    'property_id' => $property_id,
                    'value'       => $property_filter_value->value
                ]);
            }
        }

        return true;
    }


    public function copyTranslateDescription($property_id,$translate_descriptions){

        if(!empty($translate_descriptions)){

            foreach($translate_descriptions as $translate_description){
                    TranslateDescription::create([
                        'property_id' => $property_id,
                        'language_id' => $translate_description->language_id,
                        'description' => $translate_description->description
                    ]);


            }

        }

        return true;


    }


    public function savePhone($property_id, $phones){

        if(!empty($phones)){
            foreach($phones as $phone){
                    PropertyAttachPhone::create([
                        'code'        => $phone->code,
                        'number'      => $phone->number,
                        'viber'       => $phone->viber,
                        'whatsapp'    => $phone->whatsapp,
                        'telegram'    => $phone->telegram,
                        'property_id' => $property_id
                    ]);
            }
        }

        return true;

    }




}
