<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App\Http\Traits\ConfigTrait;

class LoginInputValidationDirective extends ValidationDirective 
{
    use ConfigTrait;

    public function rules(): array
    {
        $this->setLanguage($this->args);  
        
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
