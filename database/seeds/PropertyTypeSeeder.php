<?php

use Illuminate\Database\Seeder;
use PropertyType;

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
            ['name' => 'undefined','icon_class' => 'fa fa-home'],
            ['name' => 'other','icon_class' => 'fa fa-home'],
            ['name' => 'home' ,'icon_class' => 'fa fa-home'],
        ];
    
        foreach ($items as $item) {
            PropertyType::create($item);
        }
    }
}
