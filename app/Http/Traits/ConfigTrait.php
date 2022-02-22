<?php

namespace  App\Http\Traits;

use App;
use App\Singleton\RestCurrency;

trait ConfigTrait {
    
    public function setLanguage($args) {
        if(array_key_exists('language', $args)&&in_array($args['language'],Config('languages.languages'))){        
            App::setLocale($args['language']);
        }
    }

    public function setCurrency($args) {
        if(array_key_exists('currency_id', $args)){        
            app('RestCurrency')->setCurrency($args['currency_id']);
        }
    }


}