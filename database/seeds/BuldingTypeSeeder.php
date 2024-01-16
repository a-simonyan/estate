<?php

use Illuminate\Database\Seeder;

class BuldingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\BuldingType::class, 10)->create();
    }
}
