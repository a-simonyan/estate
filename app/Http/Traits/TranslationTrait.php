<?php

namespace  App\Http\Traits;

use App\Language;
use App\Translation;
use App;

trait TranslationTrait {
    
    public function translat($value) {
            $language_code = App::getLocale();
            $language = Language::where('code',$language_code)->first();
            if($language){
                $language_id = $language->id;
                $translation = Translation::where('name',$value)->where('language_id',$language_id)->first();
                 if($translation){
                      return $translation->translated_name;
                 }
            } 

            return $value;
            
    }


}