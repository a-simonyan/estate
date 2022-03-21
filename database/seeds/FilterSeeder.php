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
            ['name' => 'new_building','filter_group_id'=>1],                                 // 1 
            ['name' => 'area','filter_group_id'=>1],                                         // 2
            ['name' => 'number_of_floors_of_the_building','filter_group_id'=>1],             // 3
            ['name' => 'apartment_floor','filter_group_id'=>1],                              // 4
            ['name' => 'number_of_rooms','filter_group_id'=>1],                              // 5
            ['name' => 'number_of_bathrooms','filter_group_id'=>1],                          // 6
          
   
            ['name' => 'gas','filter_group_id'=>2],                                          // 7 Essentials - Հիմնական
            ['name' => 'electricity','filter_group_id'=>2],                                  // 8
            ['name' => 'permanent_water','filter_group_id'=>2],                              // 9
            ['name' => 'irrigation','filter_group_id'=>2],                                   // 10
            ['name' => 'drainage','filter_group_id'=>2],                                     // 11
            ['name' => 'sewage','filter_group_id'=>2],                                       // 12
            ['name' => 'trash_collection','filter_group_id'=>2],                             // 13
            ['name' => 'cable_tv','filter_group_id'=>2],                                     // 14
            ['name' => 'internet','filter_group_id'=>2],                                     // 15
            ['name' => 'phone_service','filter_group_id'=>2],                                // 16
   
            ['name' => 'sauna','filter_group_id'=>3,'deal_type'=>'sell'],                    // 17 Facilities and assets - Հարմարություններ և առավելություններ 
            ['name' => 'hot_tub','filter_group_id'=>3,'deal_type'=>'sell'],                  // 18
            ['name' => 'pool','filter_group_id'=>3,'deal_type'=>'sell'],                     // 19
            ['name' => 'garage','filter_group_id'=>3,'deal_type'=>'sell'],                   // 20
            ['name' => 'attic','filter_group_id'=>3,'deal_type'=>'sell'],                    // 21
            ['name' => 'basement','filter_group_id'=>3,'deal_type'=>'sell'],                 // 22
            ['name' => 'storage_room','filter_group_id'=>3,'deal_type'=>'sell'],             // 23
            ['name' => 'backyard','filter_group_id'=>3,'deal_type'=>'sell'],                 // 24
            ['name' => 'outdoor_dining_area','filter_group_id'=>3,'deal_type'=>'sell'],      // 25
            ['name' => 'outdoor_kitchen','filter_group_id'=>3,'deal_type'=>'sell'],          // 26
            ['name' => 'high_first_floor','filter_group_id'=>3,'deal_type'=>'sell'],         // 27
            ['name' => 'single_level_home','filter_group_id'=>3,'deal_type'=>'sell'],        // 28
            ['name' => 'wheelchair_accessible','filter_group_id'=>3,'deal_type'=>'sell'],    // 29
            ['name' => 'elevator','filter_group_id'=>3,'deal_type'=>'sell'],                 // 30
            ['name' => 'new_wiring','filter_group_id'=>3,'deal_type'=>'sell'],               // 31
            ['name' => 'new_water_tubes','filter_group_id'=>3,'deal_type'=>'sell'],          // 32
            ['name' => 'sunny','filter_group_id'=>3,'deal_type'=>'sell'],                    // 33
            ['name' => 'closed_balcony','filter_group_id'=>3,'deal_type'=>'sell'],           // 34
            ['name' => 'open_balcony','filter_group_id'=>3,'deal_type'=>'sell'],             // 35
            ['name' => 'hot_water','filter_group_id'=>3,'deal_type'=>'sell'],                // 36
            ['name' => 'kitchen_furniture','filter_group_id'=>3,'deal_type'=>'sell'],        // 37
            ['name' => 'furnished','filter_group_id'=>3,'deal_type'=>'sell'],                // 38
   
            ['name' => 'heating','filter_group_id'=>4,'deal_type'=>'sell'],                  // 39 Heating and cooling - Ջեռուցում և հովացում
            ['name' => 'fireplace','filter_group_id'=>4,'deal_type'=>'sell'],                // 40
            ['name' => 'air_conditioner','filter_group_id'=>4,'deal_type'=>'sell'],          // 41
            ['name' => 'turbo_charger','filter_group_id'=>4,'deal_type'=>'sell'],            // 42
            ['name' => 'heating_floor','filter_group_id'=>4,'deal_type'=>'sell'],            // 43
            ['name' => 'portable_fans','filter_group_id'=>4,'deal_type'=>'sell'],            // 44
            ['name' => 'ceiling_fan','filter_group_id'=>4,'deal_type'=>'sell'],              // 45

            ['name' => 'security_system','filter_group_id'=>5,'deal_type'=>'sell'],          // 46 Safety -անվտանգություն, Безопасность
            ['name' => 'smoke_alarm','filter_group_id'=>5,'deal_type'=>'sell'],              // 47
            ['name' => 'fire_extinguisher','filter_group_id'=>5,'deal_type'=>'sell'],        // 48
            ['name' => 'carbon_monoxide_detector','filter_group_id'=>5,'deal_type'=>'sell'], // 49

            ['name' => 'roadside','filter_group_id'=>6,'deal_type'=>'sell'],                  // 50 Location features - Տեղանքի առանձնահատկությունները
            ['name' => 'private_entrance','filter_group_id'=>6,'deal_type'=>'sell'],          // 51
            ['name' => 'waterfront','filter_group_id'=>6,'deal_type'=>'sell'],                // 52
            ['name' => 'playground','filter_group_id'=>6,'deal_type'=>'sell'],                // 53
            ['name' => 'park','filter_group_id'=>6,'deal_type'=>'sell'],                      // 54
            ['name' => 'near_the_bus_stop','filter_group_id'=>6,'deal_type'=>'sell'],         // 55
            ['name' => 'petrol_station','filter_group_id'=>6,'deal_type'=>'sell'],            // 56
            ['name' => 'gym','filter_group_id'=>6,'deal_type'=>'sell'],                       // 57
            ['name' => 'parking','filter_group_id'=>6,'deal_type'=>'sell'],                   // 58

            ['name' => 'carpet','filter_group_id'=>7,'deal_type'=>'sell'],                    // 59 windows, doors, floors and walls - պատուհան, դուռ, հատակ և պատ
            ['name' => 'vinyl','filter_group_id'=>7,'deal_type'=>'sell'],                     // 60
            ['name' => 'tile','filter_group_id'=>7,'deal_type'=>'sell'],                      // 61
            ['name' => 'hardwood','filter_group_id'=>7,'deal_type'=>'sell'],                  // 62
            ['name' => 'laminate','filter_group_id'=>7,'deal_type'=>'sell'],                  // 63
            ['name' => 'grills','filter_group_id'=>7,'deal_type'=>'sell'],                    // 64
            ['name' => 'iron_door','filter_group_id'=>7,'deal_type'=>'sell'],                 // 65
            ['name' => 'fence','filter_group_id'=>7,'deal_type'=>'sell'],                     // 66
            ['name' => 'parquet','filter_group_id'=>7,'deal_type'=>'sell'],                   // 67
            ['name' => 'gate','filter_group_id'=>7,'deal_type'=>'sell'],                      // 68
            ['name' => 'euro_windows','filter_group_id'=>7,'deal_type'=>'sell'],              // 69
   
            ['name' => 'sauna','filter_group_id'=>3,'deal_type'=>'rent'],                     // 70 Facilities and assets - Հարմարություններ և առավելություններ 
            ['name' => 'hot_tub','filter_group_id'=>3,'deal_type'=>'rent'],                   // 71
            ['name' => 'pool','filter_group_id'=>3,'deal_type'=>'rent'],                      // 72
            ['name' => 'garage','filter_group_id'=>3,'deal_type'=>'rent'],                    // 73
            ['name' => 'attic','filter_group_id'=>3,'deal_type'=>'rent'],                     // 74
            ['name' => 'basement','filter_group_id'=>3,'deal_type'=>'rent'],                  // 75
            ['name' => 'storage_room','filter_group_id'=>3,'deal_type'=>'rent'],              // 76
            ['name' => 'backyard','filter_group_id'=>3,'deal_type'=>'rent'],                  // 77
            ['name' => 'outdoor_dining_area','filter_group_id'=>3,'deal_type'=>'rent'],       // 78
            ['name' => 'outdoor_kitchen','filter_group_id'=>3,'deal_type'=>'rent'],           // 79
            ['name' => 'high_first_floor','filter_group_id'=>3,'deal_type'=>'rent'],          // 80
            ['name' => 'single_level_home','filter_group_id'=>3,'deal_type'=>'rent'],        // 81
            ['name' => 'wheelchair_accessible','filter_group_id'=>3,'deal_type'=>'rent'],     // 82
            ['name' => 'elevator','filter_group_id'=>3,'deal_type'=>'rent'],                  // 83
            ['name' => 'new_wiring','filter_group_id'=>3,'deal_type'=>'rent'],                // 84
            ['name' => 'new_water_tubes','filter_group_id'=>3,'deal_type'=>'rent'],           // 85
            ['name' => 'sunny','filter_group_id'=>3,'deal_type'=>'rent'],                     // 86
            ['name' => 'closed_balcony','filter_group_id'=>3,'deal_type'=>'rent'],            // 87
            ['name' => 'open_balcony','filter_group_id'=>3,'deal_type'=>'rent'],              // 88
            ['name' => 'hot_water','filter_group_id'=>3,'deal_type'=>'rent'],                 // 89
            ['name' => 'toiletries','filter_group_id'=>3,'deal_type'=>'rent'],                // 90
            ['name' => 'bed_linen','filter_group_id'=>3,'deal_type'=>'rent'],                 // 91
            ['name' => 'cleaning_products','filter_group_id'=>3,'deal_type'=>'rent'],         // 92
   
            ['name' => 'heating','filter_group_id'=>4,'deal_type'=>'rent'],                   // 93 Heating and cooling - Ջեռուցում և հովացում
            ['name' => 'fireplace','filter_group_id'=>4,'deal_type'=>'rent'],                 // 94
            ['name' => 'air_conditioner','filter_group_id'=>4,'deal_type'=>'rent'],           // 95
            ['name' => 'turbo_charger','filter_group_id'=>4,'deal_type'=>'rent'],             // 96
            ['name' => 'heating_floor','filter_group_id'=>4,'deal_type'=>'rent'],             // 97
            ['name' => 'portable_fans','filter_group_id'=>4,'deal_type'=>'rent'],             // 98
            ['name' => 'ceiling_fan','filter_group_id'=>4,'deal_type'=>'rent'],               // 99

            ['name' => 'security_system','filter_group_id'=>5,'deal_type'=>'rent'],           // 100 Safety -անվտանգություն, Безопасность
            ['name' => 'smoke_alarm','filter_group_id'=>5,'deal_type'=>'rent'],               // 101
            ['name' => 'fire_extinguisher','filter_group_id'=>5,'deal_type'=>'rent'],         // 102
            ['name' => 'carbon_monoxide_detector','filter_group_id'=>5,'deal_type'=>'rent'],  // 103

            ['name' => 'roadside','filter_group_id'=>6,'deal_type'=>'rent'],                  // 104 Location features - Տեղանքի առանձնահատկությունները
            ['name' => 'private_entrance','filter_group_id'=>6,'deal_type'=>'rent'],          // 105
            ['name' => 'waterfront','filter_group_id'=>6,'deal_type'=>'rent'],                // 106
            ['name' => 'playground','filter_group_id'=>6,'deal_type'=>'rent'],                // 107
            ['name' => 'park','filter_group_id'=>6,'deal_type'=>'rent'],                      // 108
            ['name' => 'near_the_bus_stop','filter_group_id'=>6,'deal_type'=>'rent'],         // 109
            ['name' => 'petrol_station','filter_group_id'=>6,'deal_type'=>'rent'],            // 110
            ['name' => 'gym','filter_group_id'=>6,'deal_type'=>'rent'],                       // 111
            ['name' => 'parking','filter_group_id'=>6,'deal_type'=>'rent'],                   // 112

            ['name' => 'carpet','filter_group_id'=>7,'deal_type'=>'rent'],                    // 113 windows, doors, floors and walls - պատուհան, դուռ, հատակ և պատ
            ['name' => 'vinyl','filter_group_id'=>7,'deal_type'=>'rent'],                     // 114
            ['name' => 'tile','filter_group_id'=>7,'deal_type'=>'rent'],                      // 115
            ['name' => 'hardwood','filter_group_id'=>7,'deal_type'=>'rent'],                  // 116
            ['name' => 'laminate','filter_group_id'=>7,'deal_type'=>'rent'],                  // 117
            ['name' => 'grills','filter_group_id'=>7,'deal_type'=>'rent'],                    // 118
            ['name' => 'iron_door','filter_group_id'=>7,'deal_type'=>'rent'],                 // 119
            ['name' => 'fence','filter_group_id'=>7,'deal_type'=>'rent'],                     // 120
            ['name' => 'parquet','filter_group_id'=>7,'deal_type'=>'rent'],                   // 121
            ['name' => 'gate','filter_group_id'=>7,'deal_type'=>'rent'],                      // 122
            ['name' => 'euro_windows','filter_group_id'=>7,'deal_type'=>'rent'],              // 123

            ['name' => 'washer','filter_group_id'=>8,'deal_type'=>'rent'],                    // 124 Appliances - Կենցաղային տեխնիկա
            ['name' => 'dishwasher','filter_group_id'=>8,'deal_type'=>'rent'],                // 125
            ['name' => 'dryer','filter_group_id'=>8,'deal_type'=>'rent'],                     // 126
            ['name' => 'drying rack','filter_group_id'=>8,'deal_type'=>'rent'],               // 127
            ['name' => 'fridge','filter_group_id'=>8,'deal_type'=>'rent'],                    // 128
            ['name' => 'mini_fridge','filter_group_id'=>8,'deal_type'=>'rent'],               // 129
            ['name' => 'freezer','filter_group_id'=>8,'deal_type'=>'rent'],                   // 130
            ['name' => 'microwave','filter_group_id'=>8,'deal_type'=>'rent'],                 // 131
            ['name' => 'stove','filter_group_id'=>8,'deal_type'=>'rent'],                     // 132
            ['name' => 'oven','filter_group_id'=>8,'deal_type'=>'rent'],                      // 133
            ['name' => 'rangehood','filter_group_id'=>8,'deal_type'=>'rent'],                 // 134
            ['name' => 'kettle','filter_group_id'=>8,'deal_type'=>'rent'],                    // 135
            ['name' => 'bread_maker','filter_group_id'=>8,'deal_type'=>'rent'],               // 136
            ['name' => 'coffee_maker','filter_group_id'=>8,'deal_type'=>'rent'],              // 137
            ['name' => 'blender','filter_group_id'=>8,'deal_type'=>'rent'],                   // 138
            ['name' => 'toaster','filter_group_id'=>8,'deal_type'=>'rent'],                   // 139
            ['name' => 'mixer','filter_group_id'=>8,'deal_type'=>'rent'],                     // 140
            ['name' => 'kitchenware','filter_group_id'=>8,'deal_type'=>'rent'],               // 141
            ['name' => 'cooking_basics','filter_group_id'=>8,'deal_type'=>'rent'],            // 142
            ['name' => 'firepit','filter_group_id'=>8,'deal_type'=>'sell'],                   // 143
            ['name' => 'tV','filter_group_id'=>8,'deal_type'=>'rent'],                        // 144
            ['name' => 'speaker','filter_group_id'=>8,'deal_type'=>'rent'],                   // 145
            ['name' => 'air_purifier','filter_group_id'=>8,'deal_type'=>'rent'],              // 146
            ['name' => 'vacuum_cleaner','filter_group_id'=>8,'deal_type'=>'rent'],            // 147
            ['name' => 'hairdryer','filter_group_id'=>8,'deal_type'=>'rent'],                 // 148
            ['name' => 'iron_board','filter_group_id'=>8,'deal_type'=>'rent'],                // 149

            ['name' => 'living_room_furniture','filter_group_id'=>9,'deal_type'=>'rent'],     // 150 Furniture - Կահույք, Мебель
            ['name' => 'kitchen_furniture','filter_group_id'=>9,'deal_type'=>'rent'],         // 151
            ['name' => 'bedroom_furniture','filter_group_id'=>9,'deal_type'=>'rent'],         // 152
            ['name' => 'office_furniture','filter_group_id'=>9,'deal_type'=>'rent'],          // 153
            ['name' => 'fitness_equipment','filter_group_id'=>9,'deal_type'=>'rent'],         // 154
            ['name' => 'outdoor_furniture','filter_group_id'=>9,'deal_type'=>'rent'],         // 155
            ['name' => 'crib','filter_group_id'=>9,'deal_type'=>'rent'],                      // 156

            ['name' => 'property_height',  'filter_group_id'=>1],                             //157

            ['name' => 'land_area',  'filter_group_id'=>1],                                   //158
            
          
        ];
    
        foreach ($items as $item) {
            Filter::create($item);
        }
    }
}
