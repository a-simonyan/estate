<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Hash;
use App\Http\Traits\GetIdTrait;
use App\UserType;

class AdminCreateUser
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
        $input['email_verified_at'] = now();
        $model->fill($input);
        $model->save();

        return ['status'=>true];
    }
}
