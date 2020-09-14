<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App\Http\Traits\ConfigTrait;



class CreateLanguageValidationDirective extends ValidationDirective 
{
    public function rules(): array
    {
      $this->setLanguage($this->args);  
        
        return [
            'name' => ['required'],
            'code' => ['required'],
            'flag_image' => ['required']
        ];
    }

}
