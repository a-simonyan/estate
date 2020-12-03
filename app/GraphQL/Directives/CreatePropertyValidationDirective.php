<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreatePropertyValidationDirective extends ValidationDirective 
{
    public function rules(): array
    {
        
        return [
            'property_type'   => ['required'],
            'user_id'         => ['required'],
            'deal_type'       => ['required'],
            'property_number' => ['required'],
            'bulding_type_id' => ['required'],
            'latitude'        => ['required'],
            'longitude'       => ['required'],
            'address'         => ['required'],
            'property_images' => ['required']
        ];
    }

}
