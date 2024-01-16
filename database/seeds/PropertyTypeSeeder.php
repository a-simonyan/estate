<?php

use Illuminate\Database\Seeder;
use App\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['name' => 'apartment'],
            ['name' => 'mansion'],
            ['name' => 'land_area' ],
            ['name' => 'commercial_area' ],
        ];
    
        foreach ($items as $item) {
            PropertyType::create($item);
        }
    }
}
