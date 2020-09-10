<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App;

class LoginInputValidationDirective extends ValidationDirective 
{
    public function rules(): array
    {
        return [
            'username' => ['required'],
            'password' => ['required'],
        ];
    }
    public function messages(): array
    {   $args=$this->args;  
        if(array_key_exists('language', $args)&&in_array($args['language'],Config('languages.languages'))){        
            App::setLocale($args['language']);
        }

        return [
            'username.required' =>  __('messages.required'),
            'password.required' =>  __('messages.required'),
        ];
    }
}
