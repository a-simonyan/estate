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
      
        $model->fill($input);
        $model->save();
      
        if ($model instanceof MustVerifyEmail) {
         
            $model->url=$args['email_verification_url'];
            event(new Registered($model));

            return [
                'tokens' => [],
                'status' => 1,
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


        return [
            'tokens' => $response,
            'status' => 1,
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

    




}
