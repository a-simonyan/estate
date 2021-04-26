<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class CreatePropertyValidationDirective extends ValidationDirective 
{
    public function rules(): array
    {
        
        return [
            'property_type'     => ['required','string','in:apartment,mansion,land_area,commercial_area'],
            'deal_type'         => ['string','in:good,average,poor','nullable'],
            'bulding_type_id'   => ['required'],
            'latitude'          => ['required','numeric'],
            'longitude'         => ['required','numeric'],
            'address'           => ['required','string'],
            'property_images.*' => ['image','mimes:jpeg,jpg,png,svg,gif','nullable'],
            'property_images.0' => ['required','image','mimes:jpeg,jpg,png,svg,gif'],
        ];
    }

}
