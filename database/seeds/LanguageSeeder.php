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
            ['name' => 'Armenia','code'=>'am','flag_image'=>'https://travelarmenia.org/wp-content/uploads/2015/12/Armenia-Flag-10.jpg'],
            ['name' => 'English','code'=>'en','flag_image'=>'https://travelarmenia.org/wp-content/uploads/2015/12/Armenia-Flag-10.jpg'],
            ['name' => 'Russia' ,'code'=>'ru','flag_image'=>'https://travelarmenia.org/wp-content/uploads/2015/12/Armenia-Flag-10.jpg'],
        ];
    
        foreach ($items as $item) {
            Language::create($item);
        }
    }
}
