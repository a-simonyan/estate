<?php

namespace App\GraphQL\Mutations;

use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\BaseAuthResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Phone;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RegisterUser extends BaseAuthResolver
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $model = app(config('auth.providers.users.model'));
        $input = collect($args)->except('password_confirmation')->toArray();
        $input['password'] = Hash::make($input['password']);
        if(!empty($input['picture'])){
           $input['picture'] = $this->savePicture($input['picture'],$input['picture_type']); 
        }
        $model->fill($input);
        $model->save();
      
        if ($model instanceof MustVerifyEmail) {
         
            $model->url=$args['email_verification_url'];
            event(new Registered($model));

            return [
                'tokens' => [],
                'status' => 'must_verify_email',
            ];
        }
        $credentials = $this->buildCredentials([
            'username' => $args[config('lighthouse-graphql-passport.username')],
            'password' => $args['password'],
        ]);
        $user = $model->where(config('lighthouse-graphql-passport.username'), $args[config('lighthouse-graphql-passport.username')])->first();
        $response = $this->makeRequest($credentials);
        $response['user'] = $user;
        event(new Registered($user));

        if(!empty($input['phones'])){
            $phones=$input['phones'];
            $id=$user->id;
            $this->savePhone( $phones, $id);
        }

        return [
            'tokens' => $response,
            'status' => 'success',
        ];
    }

    public function savePhone($phones=[],$id=0){
        if($id){

            foreach($phones as $phone){
                Phone::create([
                    'number'  => $phone,
                    'user_id' => $id 
                ]);

            }
              

            return true;
        }
            return false;

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
