<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StaticPage;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(StaticPage::class, function (Faker $faker) {
    return [
        'title'   => $faker->unique()->sentence,
        'slug'    => function ($data) {
            return Str::slug($data['title']);
        },
        'content' => $faker->realText(),
    ];
});
