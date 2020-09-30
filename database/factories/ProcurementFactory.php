<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BuildingEquipment;
use App\BuildingHelpDeskCategory;
use App\BuildingProcurement;
use Faker\Generator as Faker;

$factory->define(BuildingProcurement::class, function (Faker $faker) {
    return [
        'help_desk_category_id' => fn () => BuildingHelpDeskCategory::inRandomOrder()->first()->id,
        'building_equipment_id' => fn () => BuildingEquipment::inRandomOrder()->first()->id,
        'date_of_problem'       => $faker->date('Y-m-d'),
        'date_of_problem_fixed' => $faker->unique()->dateTimeBetween('-1 years' , now()),
        'title'                 => $faker->name,
        'message'               => $faker->sentence,
        'action'                => $faker->randomElement(array_keys(BuildingProcurement::$type)),
        'cost'                  => rand(1000000, 9000000),
        'additional_information'=> $faker->sentence,
    ];
});
