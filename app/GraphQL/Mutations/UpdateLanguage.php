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
            if($args['flag_image']['type']=='png'){
            $image = $this->savePicture($args['flag_image']['image'],$args['flag_image']['type']);   
            if($image){
                $args['flag_image']=$image;
              
                $image_old = $language->flag_image;
                $language->update($args);

            


                if($image_old&&file_exists(storage_path('app/public/language/'.$image_old))){
                    unlink(storage_path('app/public/language/'.$image_old));
                  }

                

                return $language;

            } else {
                throw new ValidationException([
                    'image' => __('messages.must_be_png_type'),
                ], 'Validation Error');
    
            }
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
    

    public function savePicture($picture,$picture_type){
        if($picture&&$picture_type){
            $imageName = Str::random(10).time().'.'.$picture_type;
            while(file_exists(storage_path('app/public/language/'.$imageName))){
                $imageName = Str::random(10).time().$picture_type;
            };
            Storage::put('public/language/'.$imageName, base64_decode($picture));
            if(file_exists(storage_path('app/public/language/'.$imageName))){
                 return $imageName;
            } else {
                 return null;
            }   
        } else {
            return null;
        }

    }
}
