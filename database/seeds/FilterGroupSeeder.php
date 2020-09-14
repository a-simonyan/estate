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
            ['name' => 'other'],
            ['name' => 'utilities'],
        ];
    
        foreach ($items as $item) {
            FilterGroup::create($item);
        }
    }
}
