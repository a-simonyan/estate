<?php

use Illuminate\Database\Seeder;

use App\PropertyType;
use App\FiltersValue;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Property::class, 50)->create()->each(function($u){
            $u->property_images()->saveMany(factory(App\PropertyImage::class,3)->make() );
            $u->property_deals()->saveMany(factory(App\PropertyDeal::class,1)->make() );

            $property_type_filters = PropertyType::find($u->property_type_id)->filters;
            if($property_type_filters){
                foreach($property_type_filters as $property_type_filter){
                    FiltersValue::create([
                        'filter_id'   => $property_type_filter->id,
                        'property_id' => $u->id
                    ]);
                }
            }

        });
    }
}
