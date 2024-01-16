<?php

namespace App\GraphQL\Mutations;
use App\User;
use Laravel\Socialite\Facades\Socialite;

use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\BaseAuthResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use Illuminate\Http\Request;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\AuthenticationException;
use App\Exceptions\SendException;

class TestI extends BaseAuthResolver
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
//        $user = User::find($args['id']);
//        $credentials = $this->buildCredentials($user, 'username');
//        $response = $this->makeRequest($credentials);
//        $token = $user->createToken($user->email)->accessToken;


        $token = $args['token'];
        $user = Socialite::driver('facebook')->userFromToken($token);


       return  json_encode( $user->getAvatar());
    }
}
