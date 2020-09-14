<?php

namespace App\GraphQL\Mutations;

use App\Language;
use App\Exceptions\SendException;

class DeleteLanguage
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        
        $language = Language::find($args['id']);
        if($language){
           $image_old = $language->flag_image;
    
           if($image_old&&file_exists(storage_path('app/public/language/'.$image_old))){
               unlink(storage_path('app/public/language/'.$image_old));
           }
           $language->delete();
   
           return  $language;

        } else {
            throw new SendException(
                'error',
                __('messages.language_not_found')
              );
        }

    }
}
