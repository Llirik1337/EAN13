<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Codeean13;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Company;

$factory->define(Codeean13::class, function (Faker $faker) {
    return [
//        'code' => Str::random(13),
        'code'=>$faker->ean13,
        'tovarname' => $faker->text(100),
        // 'company_id' => factory(Company::class),
    ];
});
