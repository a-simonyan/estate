<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   

        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(TranslationSeeder::class);

        $this->call(PropertyTypeSeeder::class);
        $this->call(DealTypeSeeder::class);
        $this->call(BuldingTypeSeeder::class);

        $this->call(PropertySeeder::class);

        $this->call(FilterGroupSeeder::class);
        $this->call(FilterSeeder::class);
        $this->call(FilterPropertyTypeSeeder::class);


        $this->call(FiltersValueSeeder::class);

        $this->call(PropertyImageSeeder::class);

        $this->call(CurrencyTypeSeeder::class);
        
    }
}
