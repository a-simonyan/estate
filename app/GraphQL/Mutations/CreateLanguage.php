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
        $image = $this->savePicture($args['flag_image']);
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

    }

    public function savePicture($picture){
        if($picture){

            $fileName_img = Str::random(10).time().'.'.$picture->getClientOriginalExtension();
            while(file_exists(storage_path('app/public/language/'.$fileName_img))){
                $fileName_img = Str::random(10).time().'.'.$picture->getClientOriginalExtension();
            };
            $picture->storeAs('public/language',$fileName_img);
            if(file_exists(storage_path('app/public/language/'.$fileName_img))){
                return $fileName_img;
            } else {
                return null;
            }
        } else {
            return null;
        }

    }
}
