<?php

namespace  App\Http\Traits;
use App;
use App\Country;
use App\City;
use App\Translation;
use App\Language;
use App\Exceptions\SendException;

trait PlaceTrait{
    
    public function countryId($country_name){

        $language_code = App::getLocale();
        $language = Language::where('code',$language_code)->first();
        if($language){
             $language_id = $language->id;
             $translation = Translation::where('translated_name',$country_name)->where('language_id',$language_id)->first();

             if($translation){
                $country = Country::where('name',$translation->name)->first();
                if($country){
                    return $country->id;
                } 

             } else {
                $country = Country::where('name',$country_name)->first();  
                if($country){
                    return $country->id;
                } 
             }

             $country = Country::create(['name' => $country_name]);


             return  $country->id;  
        } 

        throw new SendException(
            'error',
            __('messages.language_code_wrong')
          );
     
    }




    public function cityId($city_name){

        $language_code = App::getLocale();
        $language = Language::where('code',$language_code)->first();
        if($language){
             $language_id = $language->id;
             $translation = Translation::where('translated_name',$city_name)->where('language_id',$language_id)->first();

             if($translation){
                $city = City::where('name',$translation->name)->first();
                if($city){
                    return $city->id;
                } 

             } else {
                $city = City::where('name',$city_name)->first();  
                if($city){
                    return $city->id;
                } 
             }

             $city = City::create(['name' => $city_name]);


             return  $city->id;  
        } 

        throw new SendException(
            'error',
            __('messages.language_code_wrong')
          );
     
    }





}