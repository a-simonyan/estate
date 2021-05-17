<?php

namespace App\GraphQL\Mutations;

use App\Language;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UpdateLanguage
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $language = Language::find($args['id']);

        if(!empty($args['flag_image'])){
            $language_picture = $language->getOriginal('flag_image');
            $image = $this->savePicture($args['flag_image'],$language_picture);
            if($image){
                $args['flag_image']=$image;
                $language->update($args);

                return $language;

            } else {
                throw new ValidationException([
                    'image' => __('messages.must_be_png_type'),
                ], 'Validation Error');
    
            }

      } else {
        
        $language->update($args);

          
          return $language;
      }



    }
    

    public function savePicture($picture,$language_picture){
        if($picture){

            $fileName_img = Str::random(10).time().'.'.$picture->getClientOriginalExtension();
            while(file_exists(storage_path('app/public/language/'.$fileName_img))){
                $fileName_img = Str::random(10).time().'.'.$picture->getClientOriginalExtension();
            };

            $picture->storeAs('public/language',$fileName_img);

            if(file_exists(storage_path('app/public/language/'.$fileName_img))){

                if($language_picture&&file_exists(storage_path('app/public/language/'.$language_picture))){
                    unlink(storage_path('app/public/language/'.$language_picture));
                }

                return $fileName_img;
            } else {
                return $language_picture;
            }
        } else {
            return $language_picture;
        }

    }
}
