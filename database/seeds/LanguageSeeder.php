<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [            
            ['name' => 'Armenia'],
            ['name' => 'English'],
            ['name' => 'Russia'],
        ];
    
        foreach ($items as $item) {
            Language::create($item);
        }
    }
}
