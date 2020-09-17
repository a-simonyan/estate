<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class RegisterInputValidationDirective extends ValidationDirective  
{
    
    public function rules(): array
    {
        return [
            'full_name'   => ['required', 'string'], 
            'picture'      => ['string','nullable'],
            'picture_type' => ['string','in:jpeg,jpg,png','nullable'],
            'email'        => ['required', 'email', 'unique:users'],
            'user_type_id' => ['required','numeric'],
            'password'     => ["required", "confirmed", "min:8"],
            'email_verification_url' => ['required', 'string'],
        ];
    }
    
}
