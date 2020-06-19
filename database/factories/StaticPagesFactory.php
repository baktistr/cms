<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StaticPages;
use Faker\Generator as Faker;
use Illuminate\Support\Str ;

$factory->define(StaticPages::class, function (Faker $faker) {
    return [
        'title'     => $faker->unique()->sentence,
        'slug'      => Str::slug($faker->unique()->sentence, '-'),
        'content'   => $faker->paragraph,
    ];
});
