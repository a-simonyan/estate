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
        'first_name' => $faker->name,
        'last_name'  => $faker->lastName,
        'picture' =>$faker->imageUrl($width = 640, $height = 480),
        'email' => $faker->unique()->safeEmail,
        'user_type_id' => 1,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
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







$factory->define(PropertyType::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->word,
        'icon_class' => 'fa fa-home'
    ];
});

$factory->define(DealType::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->word,
    ];
});

$factory->define(BuldingType::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->word,
    ];
});

$factory->define(Country::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->country,
    ];
});

$factory->define(City::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->city,
    ];
});

$factory->define(Property::class, function(Faker $faker){
    return [
        'property_type_id' => 1,
        'user_id' => $faker->numberBetween($min = 1, $max = 2),
        'property_number' => $faker->buildingNumber,
        'bulding_type_id' => $faker->numberBetween($min = 1, $max = 10),
        'latitude' => $faker->unique()->latitude($min = -90, $max = 90),
        'longitude' => $faker->unique()->longitude($min = -180, $max = 180),
        'country_id' => $faker->numberBetween($min = 1, $max = 5),
        'city_id' => $faker->numberBetween($min = 1, $max = 50),
        'address' => $faker->address,
        'postal_code' => $faker->postcode,
        'property_state' => $faker->randomElement(['good','average','poor']),
    ];
});
$factory->define(PropertyDeal::class, function(Faker $faker){
    return [
        'deal_type_id' => $faker->numberBetween($min = 1, $max = 10),
        'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 1000)        
    ];
});


$factory->define(Filter::class, function(Faker $faker){
    return [
        'name' => $faker->unique()->word,
        'filter_type' => $faker->randomElement(['text','number','checkbox']),
        'icon_class' => 'fa fa-home',
        'filter_group_id' => $faker->randomElement([ null,1,2]),

    ];
});

$factory->define(FilterPropertyType::class, function(Faker $faker){
    return [
        'property_type_id' => 1,
    ];
});

$factory->define(FiltersValue::class, function(Faker $faker){
    return [
        'filter_id' => $faker->numberBetween($min = 1, $max = 10),
        'property_id' => $faker->numberBetween($min = 1, $max = 10),
        'value' => $faker->unique()->word,
    ];
});

$factory->define(PropertyImage::class, function(Faker $faker){
    return [
        'property_id' => $faker->numberBetween($min = 1, $max = 50),
        'name' => $faker->imageUrl($width = 640, $height = 480),
    ];
});

