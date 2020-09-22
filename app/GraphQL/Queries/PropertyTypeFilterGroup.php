<?php

namespace App\GraphQL\Queries;

use App\Filter;
use App\PropertyType;
use App\FilterGroup;

class PropertyTypeFilterGroup
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if(!empty($args['property_type_id'])){
           $property_type_id = $args['property_type_id'];
        } else {
           $property_type_id = null;
        }

        $filterGroup = FilterGroup::with(['filters' => function ($query) use ($property_type_id) {
             $query->leftJoin('filter_property_types', 'filters.id', '=', 'filter_property_types.filter_id');
             if($property_type_id){
               $query->where('property_type_id', $property_type_id);
             };
               $query->select('filters.*'); 
             }])->get();
        return json_encode($filterGroup);
    }
}
