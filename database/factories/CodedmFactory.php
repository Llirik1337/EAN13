<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Codedm;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Codeean13;
use App\Statuscodedm;

$factory->define(Codedm::class, function (Faker $faker) {
    return [
        //
        'code' => Str::random(128),
        'codeean13_id' => factory(Codeean13::class),
        // 'status_id' => factory(Statuscodedm::class)
    ];
});
