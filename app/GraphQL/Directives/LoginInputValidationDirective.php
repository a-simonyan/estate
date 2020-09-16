<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class LoginInputValidationDirective extends ValidationDirective 
{

    public function rules(): array
    {
        
        return [
            'username' => ['required'],
            'password' => ['required'],
        ];
    }
    // public function messages(): array
    // {   
    //     $this->setLanguage($this->args);  
    //     return [
    //         'username.required' =>  __('messages.validation_required'),
    //         'password.required' =>  __('messages.validation_required'),
    //     ];
    // }
}
