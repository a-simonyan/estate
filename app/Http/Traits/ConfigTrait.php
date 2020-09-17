<?php

namespace  App\Http\Traits;
use App;

trait ConfigTrait {
    
    public function setLanguage($args) {
        if(array_key_exists('language', $args)&&in_array($args['language'],Config('languages.languages'))){        
            App::setLocale($args['language']);
        }
    }


}