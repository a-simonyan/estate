<?php

use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Filter::class, 10)->create()->each(function($u){
            $u->filter_property_types()->saveMany(factory(App\FilterPropertyType::class,1)->make() );
        });
    }
}
