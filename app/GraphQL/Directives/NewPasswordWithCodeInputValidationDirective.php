<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App\Http\Traits\ConfigTrait;


class NewPasswordWithCodeInputValidationDirective extends ValidationDirective 
{
    use ConfigTrait;

    public function rules(): array
    {
        $this->setLanguage($this->args);  

        return [
            'email'    => ['required', 'email'],
            'token'    => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required', 'string'],
        ];
    }
  
}
