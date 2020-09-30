<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Area;
use App\AreaDisputeHistory;
use Faker\Generator as Faker;

$factory->define(AreaDisputeHistory::class, function (Faker $faker) {
    return [
        'area_id'       => function () {
            return factory(Area::class)->create()->id;
        },
        'location_code' => $faker->uuid,
        'type'          => 'done',
    ];
});
