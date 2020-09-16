<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;


class ForgotPasswordInputValidationDirective extends ValidationDirective 
{

    public function rules(): array
    {

        return [
            'email' => ['required', 'email'],
            'password_reset_url' => ['required']
        ];
    }
 
}
