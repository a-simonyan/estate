<?php

use Illuminate\Database\Seeder;
use App\DealType;

class DealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [          
            ['name' => 'sale'],  
            ['name' => 'monthly_rental_fee'],
            ['name' => 'daily_rental_fee'],
        ];
    
        foreach ($items as $item) {
            DealType::create($item);
        }
    }
}
