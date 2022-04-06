<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use Illuminate\Support\Facades\Http;

class AdminRegisterInputValidationDirective extends ValidationDirective  
{
    
    public function rules(): array
    {
        

        return [
            'full_name'    => ['required', 'string'], 
            'email'        => ['required_without:login_phone', 'email', 'unique:users'],
            'login_phone'  => ['required_without:email', 'unique:users'],
            'user_type'    => ['required','string'],
            'password'     => ['required', 'min:8'],
            'password_confirmation' => ['required','same:password'],
        ];
    }


     public function messages(): array
    {   
        
        return [
            'password_confirmation.same' =>  __('messages.same_password_validation'),
        ];
    }
    
}
