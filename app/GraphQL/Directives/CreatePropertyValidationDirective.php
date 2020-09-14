<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App\Http\Traits\ConfigTrait;

class CreatePropertyValidationDirective extends ValidationDirective 
{
    use ConfigTrait;

    public function rules(): array
    {
        $this->setLanguage($this->args);  
        
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
