<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Statuscodedm;
use Faker\Generator as Faker;

$factory->define(Statuscodedm::class, function (Faker $faker) {
    return [
        'name' => 'not printed'
    ];
});
