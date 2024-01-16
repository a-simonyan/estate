<?php

namespace App\GraphQL\Mutations;

use App\User;
use Laravel\Socialite\Facades\Socialite;
use App\UserType;
use App\Http\Traits\GetIdTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exceptions\SendException;

class SocialLoginUser
{
    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $token    = $args['token'];
        $provider = $args['provider'];
        $userSocial = Socialite::driver($provider)->userFromToken($token);

        if($userSocial){
            $user = User::where(['email' => $userSocial->getEmail()])->first();
            if($user){
                $access_token = $user->createToken($user->email)->accessToken;;
            }else{
                $avatar_image =  $userSocial->getAvatar();
                $picture = $this->getSocialAvatar($avatar_image);
                $user = User::create([
                    'full_name'         => $userSocial->getName(),
                    'picture'           => $picture,
                    'email'             => $userSocial->getEmail(),
                    'user_type_id'      => $this->getKeyId(UserType::Class,'name','individual'),
                    'email_verified_at' => now(),
                    'provider_id'       => $userSocial->getId(),
                    'provider'          => $provider,
                ]);
                $access_token = $user->createToken($user->email)->accessToken;
            }

            return ['access_token' => $access_token, 'user' => $user];
        } else {
            throw new SendException(
                'error',
                __('messages.user_not_found')
            );
        }
    }


    function getSocialAvatar($file){
        if($file) {
            $fileContents = file_get_contents($file);
            $fileName_img = Str::random(10) . time() . '.jpg';
            while (file_exists(storage_path('app/public/users/' . $fileName_img))) {
                $fileName_img = Str::random(10) . time() . '.jpg';
            };
            Storage::put('public/users/' . $fileName_img, $fileContents);
            Storage::put('public/users/min/' . $fileName_img, $fileContents);

            return $fileName_img;
        }
        return null;
    }


}
