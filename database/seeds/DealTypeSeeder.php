<?php

use Illuminate\Database\Seeder;

class DealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DealType::class, 10)->create();
    }
}
