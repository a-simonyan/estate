<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;


class NewPasswordWithCodeInputValidationDirective extends ValidationDirective 
{

    public function rules(): array
    {

        return [
            'email'    => ['required', 'email'],
            'token'    => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required', 'string'],
        ];
    }
  
}
