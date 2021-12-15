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
            ['name' => 'sale'],                //1
            ['name' => 'monthly_rental_fee'],  //2
            ['name' => 'daily_rental_fee'],    //3
        ];
    
        foreach ($items as $item) {
            DealType::create($item);
        }
    }
}
