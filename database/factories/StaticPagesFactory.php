<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StaticPages;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(StaticPages::class, function (Faker $faker) {
    return [
        'title'     => $faker->unique()->sentence,
        'slug'      => function ($data) {
            return Str::slug($data['title']);
        },
        'content'   => $faker->paragraph,
    ];
});
