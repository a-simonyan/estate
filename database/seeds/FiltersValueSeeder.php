<?php

use Illuminate\Database\Seeder;

class FiltersValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\FiltersValue::class, 10)->create();
    }
}
