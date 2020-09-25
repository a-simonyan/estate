<?php

namespace App\GraphQL\Mutations;

class UpdateUserProfile
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // if(!empty($args['image']){

        //     $this->savePicture($args['image']['image'], $args['image']['type']);
        // }
    }

    public function savePicture($picture,$picture_type){
        if($picture&&$picture_type){
            $imageName = Str::random(10).time().'.'.$picture_type;
            while(file_exists(storage_path('app/public/users/'.$imageName))){
                $imageName = Str::random(10).time().$picture_type;
            };
            Storage::put('public/users/'.$imageName, base64_decode($picture));
            if(file_exists(storage_path('app/public/users/'.$imageName))){
                 return $imageName;
            } else {
                 return null;
            }   
        } else {
            return null;
        }

    }
}
