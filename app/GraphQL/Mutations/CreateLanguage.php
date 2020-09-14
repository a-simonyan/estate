<?php

namespace App\GraphQL\Mutations;
use App\Language;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CreateLanguage
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if($args['flag_image']['type']=='png'){

        $image = $this->savePicture($args['flag_image']['image'],$args['flag_image']['type']);   
        if($image){
            $arr=[
                'name' => $args['name'],
                'code' => $args['code'],
                'flag_image' =>  $image,
            ];
    
            $language = Language::create($arr);
    
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
