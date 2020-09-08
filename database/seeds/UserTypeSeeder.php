<?php

use Illuminate\Database\Seeder;
use App\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $items = [            
            ['name' => 'admin'],
            ['name' => 'user'],
        ];
    
        foreach ($items as $item) {
            UserType::create($item);
        }
    }
}
