<?php

use Illuminate\Database\Seeder;
use App\Filter;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [          
            ['name' => 'new_building','filter_group_id'=>1],                            // 1
            ['name' => 'area','filter_group_id'=>1],                                    // 2
            ['name' => 'number_of_floors_of_the_building','filter_group_id'=>1],        // 3
            ['name' => 'apartment_floor','filter_group_id'=>1],                         // 4
            ['name' => 'number_of_rooms','filter_group_id'=>1],                         // 5
            ['name' => 'number_of_bathrooms','filter_group_id'=>1],                     // 6
            ['name' => 'heating','filter_group_id'=>2],                                 // 7
            ['name' => 'gas','filter_group_id'=>2],                                     // 8
            ['name' => 'hot_water','filter_group_id'=>2],                               // 9
            ['name' => 'electrycity','filter_group_id'=>2],                             // 10
            ['name' => 'permanent_water','filter_group_id'=>2],                         // 11
            ['name' => 'internet','filter_group_id'=>2],                                // 12
            ['name' => 'air_conditioner','filter_group_id'=>2],                         // 13
            ['name' => 'irrigation','filter_group_id'=>2],                              // 14
            ['name' => 'drainage','filter_group_id'=>2],                                // 15
            ['name' => 'furniture','filter_group_id'=>3],                               // 16
            ['name' => 'attic','filter_group_id'=>3],                                   // 17
            ['name' => 'grilles','filter_group_id'=>3],                                 // 18
            ['name' => 'parquet','filter_group_id'=>3],                                 // 19
            ['name' => 'bilateral','filter_group_id'=>3],                               // 20
            ['name' => 'elevator','filter_group_id'=>3],                                // 21
            ['name' => 'parking','filter_group_id'=>3],                                 // 22
            ['name' => 'technique','filter_group_id'=>3],                               // 23
            ['name' => 'roadside','filter_group_id'=>3],                                // 24
            ['name' => 'turbocharger','filter_group_id'=>3],                            // 25
            ['name' => 'sunny','filter_group_id'=>3],                                   // 26
            ['name' => 'iron_door','filter_group_id'=>3],                               // 27
            ['name' => 'heating_floor','filter_group_id'=>3],                           // 28
            ['name' => 'open_balcony','filter_group_id'=>3],                            // 29
            ['name' => 'park','filter_group_id'=>3],                                    // 30
            ['name' => 'fireplace','filter_group_id'=>3],                               // 31
            ['name' => 'beautiful_view','filter_group_id'=>3],                          // 32
            ['name' => 'basement','filter_group_id'=>3],                                // 33
            ['name' => 'high_first_floor','filter_group_id'=>3],                        // 34
            ['name' => 'closed_balcony','filter_group_id'=>3],                          // 35
            ['name' => 'playground','filter_group_id'=>3],                              // 36
            ['name' => 'storage_room','filter_group_id'=>3],                            // 37
            ['name' => 'near_the_bus_stop','filter_group_id'=>3],                       // 38
            ['name' => 'gym','filter_group_id'=>3],                                     // 39
            ['name' => 'laminate','filter_group_id'=>3],                                // 40
            ['name' => 'loggia','filter_group_id'=>3],                                  // 41
            ['name' => 'garage','filter_group_id'=>3],                                  // 42
            ['name' => 'euro_window','filter_group_id'=>3],                             // 43
            ['name' => 'availability_of_building','filter_group_id'=>3],                // 44
            ['name' => 'sauna','filter_group_id'=>3],                                   // 45
            ['name' => 'security_system','filter_group_id'=>3],                         // 46
            ['name' => 'gate','filter_group_id'=>3],                                    // 47
            ['name' => 'swimming_pool','filter_group_id'=>3],                           // 48
            ['name' => 'fenced','filter_group_id'=>3],                                  // 49
          
        ];
    
        foreach ($items as $item) {
            Filter::create($item);
        }
    }
}
