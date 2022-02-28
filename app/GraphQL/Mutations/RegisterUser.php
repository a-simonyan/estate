<?php

namespace App\GraphQL\Mutations;

use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\BaseAuthResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\UserType;
use App\Http\Traits\GetIdTrait;


class RegisterUser extends BaseAuthResolver
{
    use GetIdTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        

        $model = app(config('auth.providers.users.model'));
        $input = collect($args)->except(['user_type','password_confirmation'])->toArray();
        $input['password'] = Hash::make($input['password']);
        $input['user_type_id'] = $this->getKeyId(UserType::Class,'name',$args['user_type']); 
        $model->fill($input);
        // $model->save();
      
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

    // public function savePhone($phones=[],$id=0){
    //     if($id){

    //         foreach($phones as $phone){
    //             Phone::create([
    //                 'number'  => $phone,
    //                 'user_id' => $id 
    //             ]);

    //         }
              

    //         return true;
    //     }
    //         return false;

    // }

    




}
