<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreatePropertyValidationDirective extends ValidationDirective 
{
    public function rules(): array
    {
        
        return [
            'property_type_id'=> ['required'],
            'user_id'         => ['required'],
            'deal_type_id'    => ['required'],
            'property_number' => ['required'],
            'bulding_type_id' => ['required'],
            'latitude'        => ['required'],
            'longitude'       => ['required'],
            'country_id'      => ['required'],
            'city_id'         => ['required'],
            'address'         => ['required'],
            'property_images' => ['required']
        ];
    }

}
