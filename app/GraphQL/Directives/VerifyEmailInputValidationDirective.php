<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;


class VerifyEmailInputValidationDirective extends ValidationDirective 
{

    public function rules(): array
    {
        
        return [
            'token' => ['required'],
        ];
    }
}
