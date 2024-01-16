<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create()->each(function($u){
            $u->phones()->saveMany(factory(App\Phone::class,2)->make() );
        });
    }
}
