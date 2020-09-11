<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App\Http\Traits\ConfigTrait;


class ForgotPasswordInputValidationDirective extends ValidationDirective 
{
    use ConfigTrait;

    public function rules(): array
    {
        $this->setLanguage($this->args);  

        return [
            'email' => ['required', 'email'],
            'password_reset_url' => ['required']
        ];
    }
 
}
