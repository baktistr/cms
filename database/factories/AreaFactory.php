<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Area;
use App\District;
use App\Province;
use App\Regency;
use App\TelkomRegional;
use Faker\Generator as Faker;

$factory->define(Area::class, function (Faker $faker) {
    return [
        'code'               => $faker->randomNumber(1) . '-' . $faker->randomNumber(2) . '-' . $faker->randomNumber(2) . '-' . $faker->randomNumber(2),
        'telkom_regional_id' => function () {
            return factory(TelkomRegional::class)->create()->id;
        },
        'province_id'        => function () {
            return factory(Province::class)->create()->id;
        },
        'regency_id'         => function () {
            return factory(Regency::class)->create()->id;
        },
        'district_id'        => function () {
            return factory(District::class)->create()->id;
        },
        'address_detail'     => $faker->streetAddress,
        'latitude'           => $faker->latitude,
        'longitude'          => $faker->longitude,
        'allotment'          => $faker->optional()->sentence(),
        'surface_area'       => $faker->randomNumber(4),
        'nka_sap'            => $faker->optional()->uuid,
        'postal_code'        => $faker->postcode,
    ];
});
