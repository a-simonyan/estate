<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;

class UpdatePropertyValidationDirective extends ValidationDirective 
{
    public function rules(): array
    {
        
        return [
            'property_type'     => ['string','in:apartment,mansion,land_area,commercial_area','nullable'],
            'deal_type'         => ['string','in:good,average,poor,renovated,zero_condition','nullable','nullable'],
            'bulding_type_id'   => [],
            'land_area_type_id' => [],
            'latitude'          => ['numeric','nullable'],
            'longitude'         => ['numeric','nullable'],
            'address'           => ['string', 'nullable'],
            'property_images.*' => ['image','max:10240','mimes:jpeg,jpg,png,svg,gif','nullable'],
            'property_filter_values' => ['array','nullable'],
            'property_filter_values.*.filter' => [function ($attribute, $value, $fail) {
                $arr = explode('.', $attribute);
                $index = $arr[1];
                $filterValue = $this->args['property_filter_values'][$index]['value'];
                if($value == 'property_height'||$value == 'area'||$value == 'number_of_floors_of_the_building'||$value == 'apartment_floor'||$value == 'number_of_rooms'||$value == 'land_area'){
                    if(!is_null($filterValue) && !is_numeric($filterValue)){
                        $fail(__($value.' filter value wrong'));
                    }
                } else {
                    if(!is_null($filterValue)&&($filterValue !== 'true') && ($filterValue !== 'false') ){
                        $fail(__($value.' filter value wrong'));
                    }
                }
              
            }] 
            // 'property_images.0' => ['required','image','mimes:jpeg,jpg,png,svg,gif'],
        ];
    }

}
