<?php

namespace App\GraphQL\Mutations;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Phone;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Illuminate\Support\Facades\Hash;


class UpdateUserProfile
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $update_arr = [];
       

        if(!empty($args['image'])){
            $user_picture  =  $user->picture;
            $update_arr['picture'] = $this->savePicture($args['image']['image'], $args['image']['type'],$user_picture);
           
        }
        if(!empty($args['old_password'])&&!empty($args['password'])){
            if (!Hash::check($args['old_password'], $user->password)) {
                throw new ValidationException([
                    'old_password' => __('messages.current_password_is_incorrect'),
                ], 'Validation Exception');
            }

            $update_arr['password'] = Hash::make($args['password']);
        }


        if(!empty($args['phone'])){
            
            $this->savePhone($args['phone'],  $user_id);
            
        }


    }

    public function savePicture($picture,$picture_type, $user_picture){
        $image_types = ["jpeg","jpg","png"];
        if($picture&&$picture_type&&in_array($picture_type, $image_types)){

            if($user_picture&&file_exists(storage_path('app/public/users/'.$user_picture))){
                unlink(storage_path('app/public/users/'.$user_picture));
              }


            $imageName = Str::random(10).time().'.'.$picture_type;
            while(file_exists(storage_path('app/public/users/'.$imageName))){
                $imageName = Str::random(10).time().$picture_type;
            };
            Storage::put('public/users/'.$imageName, base64_decode($picture));

            

            if(file_exists(storage_path('app/public/users/'.$imageName))){

                if($user_picture&&file_exists(storage_path('app/public/users/'.$user_picture))){
                    unlink(storage_path('app/public/users/'.$user_picture));
                }

                return $imageName;
            } else {
                return $user_picture;
            }   
        } else {
            return $user_picture;
        }

    }

    public function savePhone($phones, $user_id){

    }
}
