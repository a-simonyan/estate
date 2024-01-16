<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\User;
use App\Singleton\RestUrl;


class ForgotPasswordUser
{
    use SendsPasswordResetEmails;
    public $restUrl;

  

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $model = app(config('auth.providers.users.model'));
        $model->password_reset_url=$args['password_reset_url'];

        app('RestUrl')->setPasswordResetUrl($args['password_reset_url']);

        $response = $this->broker()->sendResetLink(['email' => $args['email']]);
        if ($response == Password::RESET_LINK_SENT) {
            return [
                'status'  =>  1,
                'message' => __($response),
            ];
        }

        return [
            'status'  => 0,
            'message' => __($response),
        ];
    }
}
