<?php

use Illuminate\Database\Seeder;
use App\CurrencyType;

class CurrencyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [          
            ['name' => 'USD', 'symbol'=>'&#36;', 'is_current'=>false ],  
            ['name' => 'AMD', 'symbol'=>'&#36;', 'is_current'=>true ], 
            ['name' => 'EUR', 'symbol'=>'&#128;','is_current'=>false ], 
        ];
    
        foreach ($items as $item) {
            CurrencyType::create($item);
        }
    }
}
