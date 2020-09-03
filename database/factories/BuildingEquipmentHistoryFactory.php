<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BuildingEquipment;
use App\BuildingEquipmentHistory;
use Faker\Generator as Faker;

$factory->define(BuildingEquipmentHistory::class, function (Faker $faker) {
    return [
        'building_equipment_id'  => function () {
            return factory(BuildingEquipment::class)->create()->id;
        },
        'date_of_problem'        => $faker->date('Y-m-d'),
        'action'                 => $faker->randomElement(array_keys(BuildingEquipmentHistory::$type)),
        'problem'                => $faker->paragraph,
        'date_of_problem_fixed'  => $faker->unique()->dateTimeBetween('-1 years' , now()),
        'cost'                   => rand(1000000, 9000000),
        'additional_information' => $faker->sentence,
    ];
});
