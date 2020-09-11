<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App\Http\Traits\ConfigTrait;

class RegisterInputValidationDirective extends ValidationDirective  
{
    use ConfigTrait;
    
    public function rules(): array
    {
        $this->setLanguage($this->args);
        return [
            'first_name'   => ['required', 'string'], 
            'last_name'    => ['required', 'string'],
            'picture'      => ['string','nullable'],
            'picture_type' => ['string','in:jpeg,jpg,png','nullable'],
            'email'        => ['required', 'email', 'unique:users'],
            'phones'       => ['required'],
            'user_type_id' => ['required','numeric'],
            'password'     => ["required", "confirmed", "min:8"],
            'email_verification_url' => ['required', 'string'],
        ];
    }
    
}
