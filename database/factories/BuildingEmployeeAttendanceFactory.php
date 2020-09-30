<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingEmployee;
use App\BuildingEmployeeAttendance;
use Faker\Generator as Faker;

$factory->define(BuildingEmployeeAttendance::class, function (Faker $faker) {
    return [
        'building_id' => function () {
            return factory(Building::class)->create()->id;
        },
        'employee_id' => function () {
            return factory(BuildingEmployee::class)->create()->id;
        },
        'date'        => now()->subDays(rand(1, 30)),
        'status'      => $faker->randomElement(array_keys(BuildingEmployeeAttendance::$statuses)),
        'desc'        => $faker->optional(0.2)->sentence,
    ];
});
