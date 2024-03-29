<?php

namespace App\GraphQL\Mutations;
use App\User;
use App\Phone;
use App\Property;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;

class DeleteUserProfile
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if (!Auth::guard('api')->check()) {
            throw new AuthenticationException('Not Authenticated', 'Not Authenticated');
        }

        $user = Auth::user();
        $user_id = $user->id;

        if (!Hash::check($args['password'], $user->password)) {
            throw new ValidationException([
                'old_password' => __('messages.current_password_is_incorrect'),
            ], 'Validation Exception');
        }

        $user->update([ 'email'     => $user->email.'-'.now(),
                        'is_delete' => true 
                       ]);

        Property::where('user_id',$user_id)->update(['deleted_at'=>Carbon::now()]);

       
       
         // revoke user's token
         Auth::guard('api')->user()->token()->revoke();               

       return true; 
    }
}
