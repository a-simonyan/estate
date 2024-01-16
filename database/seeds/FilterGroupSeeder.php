<?php

use Illuminate\Database\Seeder;
use App\FilterGroup;

class FilterGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [          
            ['name' => 'undefined'],                      //1
            ['name' => 'essentials'],                     //2
            ['name' => 'facilities_and_assets'],          //3
            ['name' => 'heating_and_cooling'],            //4
            ['name' => 'safety'],                         //5
            ['name' => 'location_features'],              //6
            ['name' => 'windows_doors_floors_and_walls'], //7
            ['name' => 'appliances'],                     //8
            ['name' => 'furniture'],                      //9
        ];
    
        foreach ($items as $item) {
            FilterGroup::create($item);
        }
    }
}
