<?php

namespace App\GraphQL\Queries;

use App\Filter;
use App\PropertyType;
use App\FilterGroup;
use App\Property;

class PropertyFilterGroupFilters
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
      if(!empty($args['property_id'])){
            $property_type_id = Property::Find($args['property_id'])->property_type_id;
            $property_id = $args['property_id'];
       
 
         $filterGroup = FilterGroup::with(['filters' => function ($query) use ($property_type_id, $property_id) {
              $query->leftJoin('filter_property_types', 'filters.id', '=', 'filter_property_types.filter_id');
              
                $query->where('property_type_id', $property_type_id);
                $query->leftJoin('filters_values', 'filters.id', '=', 'filters_values.filter_id');
                $query->where('property_id', $property_id);
                $query->select('filters.*','filters_values.id as filters_value_id','filters_values.value');

             }])->get();
         return json_encode($filterGroup);

      }
    }
}
