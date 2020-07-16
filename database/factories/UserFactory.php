<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Company;
// use Illuminate\Support\Facades\App;

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
        'name' => $faker->name,
        'password' => bcrypt(Str::random(8)),
        'company_id' => factory(Company::class)->create(),
        'remember_token' => Str::random(10),
    ];
});

// $factory->state(User::class, 'admin', function($faker) {
//     return [
//         'user_types_id' => 1
//     ];
// });
