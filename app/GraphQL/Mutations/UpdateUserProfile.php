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
       
        if(!empty($args['full_name'])){
          $update_arr['full_name']=$args['full_name'];
        }
        if(!empty($args['email'])){
            $update_arr['email']=$args['email'];
          }

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
        if(!empty($args['update_phone'])){
            
            $this->updatePhone($args['update_phone'],  $user_id);
            
        }
        if(!empty($args['delete_phone'])){
            
            $this->deletePhone($args['delete_phone'],  $user_id);
            
        }

        if($update_arr){
           $user->update($update_arr);
        }

        return $user;

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
        foreach($phones as $phone){
            Phone::create([
                'number'   => $phone['number'],
                'user_id'  =>  $user_id,
                'viber'    => !empty($phone['viber']) ? $phone['viber'] : false,
                'whatsapp' => !empty($phone['whatsapp']) ? $phone['whatsapp'] : false,
                'telegram' => !empty($phone['telegram']) ? $phone['telegram'] : false,
            ]);
        }
        return true;
    }


    public function updatePhone($phones, $user_id){
        foreach($phones as $phone){
            $get_phone=Phone::find($phone['phone_id']);

            if($get_phone->user->id == $user_id){
                $get_phone->update([
                    'number'   => $phone['number'],
                    'viber'    => !empty($phone['viber']) ? $phone['viber'] : false,
                    'whatsapp' => !empty($phone['whatsapp']) ? $phone['whatsapp'] : false,
                    'telegram' => !empty($phone['telegram']) ? $phone['telegram'] : false,
                ]);

            }
        }

        return true; 
    }

    public function deletePhone($phone_ids, $user_id){
        foreach($phone_ids as $phone_id){
            $get_phone=Phone::find($phone_id);

            if($get_phone->user->id == $user_id){
                $get_phone->delete();
            }
        }

        return true; 

    }

}
