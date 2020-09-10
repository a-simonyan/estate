<?php

namespace App\GraphQL\Mutations;

use Joselfonseca\LighthouseGraphQLPassport\GraphQL\Mutations\BaseAuthResolver;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use Illuminate\Http\Request;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\AuthenticationException;
use App;



class LoginUser extends BaseAuthResolver
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if(array_key_exists('language', $args)&&in_array($args['language'],Config('languages.languages'))){        
             App::setLocale($args['language']);
         }  
        $user = $this->findUser($args['username']);
        if($user&&$user->email_verified_at){
         $credentials = $this->buildCredentials($args);
         $response = $this->makeRequest($credentials);

       $this->validateUser($user);
       
       return array_merge(
           $response,
           [
               'user' => $user,
           ]
       );
     } else{
       return new DefinitionException("email no verification");
     }
    }
    protected function validateUser($user)
    {
        $authModelClass = $this->getAuthModelClass();
        if ($user instanceof $authModelClass && $user->exists) {
            return;
        }

        throw (new ModelNotFoundException())->setModel(
            get_class($this->makeAuthModelInstance())
        );
    }

    protected function getAuthModelClass(): string
    {
        return config('auth.providers.users.model');
    }

    protected function makeAuthModelInstance()
    {
        $modelClass = $this->getAuthModelClass();

        return new $modelClass();
    }

    protected function findUser(string $username)
    {
        $model = $this->makeAuthModelInstance();

        if (method_exists($model, 'findForPassport')) {
            return $model->findForPassport($username);
        }

        return $model->where(config('lighthouse-graphql-passport.username'), $username)->first();
    }
    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException( __('messages.Incorrect_username_or_password'), __('messages.Incorrect_username_or_password'));
        }

        return $decodedResponse;
    }
}
