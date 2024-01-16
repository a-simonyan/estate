<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;


class CreateLanguageValidationDirective extends ValidationDirective 
{
    public function rules(): array
    {
        
        return [
            'name' => ['required'],
            'code' => ['required'],
            'flag_image' => ['required']
        ];
    }

}
