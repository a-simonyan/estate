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
            ['name' => 'undefined'],  
            ['name' => 'communal_facilities'],
            ['name' => 'other'],
        ];
    
        foreach ($items as $item) {
            FilterGroup::create($item);
        }
    }
}
