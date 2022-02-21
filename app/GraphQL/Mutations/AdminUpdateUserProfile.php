<?php

namespace App\GraphQL\Mutations;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Phone;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\SendException;
use App\Http\Traits\GetIdTrait;
use Carbon\Carbon;
use Image;

class AdminUpdateUserProfile
{
    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_id = $args['user_id'];
        $user = User::find($user_id);

        if($user) {

            $update_arr = [];
            if (isset($args['is_delete'])) {
                $update_arr['is_delete'] = $args['is_delete'];
            }
            if (isset($args['is_block'])) {
                $update_arr['is_block'] = $args['is_block'];
                if(isset($args['block_start'])){
                    $block_start = Carbon::createFromFormat('Y-m-d H:i:s', $args['block_start'])->format('Y-m-d H:i:s');
                    $update_arr['block_start'] = $block_start;
                }
                if(isset($args['block_end'])){
                    $block_end = Carbon::createFromFormat('Y-m-d H:i:s', $args['block_end'])->format('Y-m-d H:i:s');
                    $update_arr['block_end'] =  $block_end;
                }
            }

            if (isset($args['reason'])) {
                $update_arr['reason'] = $args['reason'];
            }

            if (!empty($args['full_name'])) {
                $update_arr['full_name'] = $args['full_name'];
            }
            if (!empty($args['email'])) {
                $update_arr['email'] = $args['email'];
            }

            if(!empty($args['user_type'])){
                $update_arr['user_type_id'] = $this->getKeyId(UserType::Class,'name',$args['user_type']); 
            }

            if (!empty($args['image'])) {
                $user_picture = $user->getRawOriginal('picture');
                $update_arr['picture'] = $this->savePicture($args['image'], $user_picture);

            }
            if (!empty($args['password'])) {

                $update_arr['password'] = Hash::make($args['password']);
            }


            if (!empty($args['phone'])) {

                $this->savePhone($args['phone'], $user_id);

            }
            if (!empty($args['update_phone'])) {

                $this->updatePhone($args['update_phone'], $user_id);

            }
            if (!empty($args['delete_phone'])) {

                $this->deletePhone($args['delete_phone'], $user_id);

            }

            if ($update_arr) {
                $user->update($update_arr);
            }

            return $user;

        } else {

            throw new SendException(
                'error',
                __('messages.user_not_found')
            );

        }

    }

    public function savePicture($picture, $user_picture){
        if($picture){

            $fileName_img = Str::random(10).time().'.'.$picture->getClientOriginalExtension();
            while(file_exists(storage_path('app/public/users/'.$fileName_img))){
                $fileName_img = Str::random(10).time().'.'.$picture->getClientOriginalExtension();
            };

            $picture->storeAs('public/users',$fileName_img);

            if(file_exists(storage_path('app/public/users/'.$fileName_img))){

                $image = Image::make(storage_path('app/public/users/'.$fileName_img));

                $image->resize(null, 200, function($constraint) {
                    $constraint->aspectRatio();
                });
        
                $image->save(storage_path('app/public/users/min/'.$fileName_img));

                if($user_picture&&file_exists(storage_path('app/public/users/'.$user_picture))){
                    unlink(storage_path('app/public/users/'.$user_picture));
                }

                if($user_picture&&file_exists(storage_path('app/public/users/min/'.$user_picture))){
                    unlink(storage_path('app/public/users/min/'.$user_picture));
                }  

                return $fileName_img;
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
                'code'     => $phone['code'],
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
                $get_phone->update([
                    'code'     => $phone['code'],
                    'number'   => $phone['number'],
                    'viber'    => !empty($phone['viber']) ? $phone['viber'] : false,
                    'whatsapp' => !empty($phone['whatsapp']) ? $phone['whatsapp'] : false,
                    'telegram' => !empty($phone['telegram']) ? $phone['telegram'] : false,
                ]);
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
