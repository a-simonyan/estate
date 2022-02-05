<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Phone;
use App\Translation;
use App\PropertyType;
use App\DealType;
use App\BuldingType;
use App\Country;
use App\City;
use App\Property;
use App\Filter;
use App\FiltersValue;
use App\PropertyImage;
use App\FilterPropertyType;
use App\PropertyDeal;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'full_name' => 'Mihran Baldryan',
        'picture' =>$faker->imageUrl($width = 640, $height = 480),
        'email' => 'mihran.baldryan@gmail.com',
        'user_type_id' => 1,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'is_admin' => true
    ];
});


$factory->define(Phone::class, function(Faker $faker){
    return [
        'number' => $faker->phoneNumber
    ];
});

$factory->define(Translation::class, function(Faker $faker){
    return [
        'name' => $faker->name,
        'translated_name' => $faker->name,
        'language_id' => 1
    ];
});



$factory->define(BuldingType::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->word,
    ];
});

$factory->define(Property::class, function(Faker $faker){
    $lang = 40.17759701555847;
    $long = 44.51264400786771;

    return [
        'property_key'     => $faker->numberBetween($min = 100000, $max = 999999),
        'property_type_id' => $faker->numberBetween($min = 1, $max = 4),
        'user_id'          => 43,
        'bulding_type_id'  => $faker->numberBetween($min = 1, $max = 5),
        'latitude'         => $faker->unique()->latitude($min = ($lang * 10000 - rand(0, 1000)) / 10000,
                                                         $max = ($lang * 10000 + rand(0, 1000)) / 10000),
        'longitude'        => $faker->unique()->longitude($min = ($long * 10000 - rand(0, 1000)) / 10000,
                                                          $max = ($long * 10000 + rand(0, 1000)) / 10000),
        'address'          => $faker->address,
        'postal_code'      => $faker->postcode,
        'property_state'   => $faker->randomElement(['good','average','poor']),
        'last_update'      => now(),
        'is_public_status' => 'published'

    ];
});
$factory->define(PropertyDeal::class, function(Faker $faker){
    return [
        'deal_type_id'     => $faker->numberBetween($min = 1, $max = 3),
        'price'            => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 1000),
        'currency_type_id' => $faker->numberBetween($min = 1, $max = 3),        
    ];
});


$factory->define(PropertyImage::class, function(Faker $faker){
    static $index = 1; 
    return [
        'name'  =>  url('test/test_'.$faker->numberBetween($min = 1, $max = 20).'.jpeg'),
        'index' => $index++
    ];
});

