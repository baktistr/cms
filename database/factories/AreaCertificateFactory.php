<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Area;
use App\AreaCertificate;
use Faker\Generator as Faker;
use Illuminate\Http\Testing\FileFactory;

$factory->define(AreaCertificate::class, function (Faker $faker) {
    return [
        'area_id'    => function () {
            return factory(Area::class)->create()->id;
        },
        'idareal_old'   => $faker->uuid,
        'no_certificate'=> $faker->uuid,
        'luas'          => rand(1000 , 10000),
        'sk_hak'        => 'HB-'.rand(10,100),
        'end'           => now()->addDays(rand(4, 7)),
        'loker'         => rand(100 , 288),
        'bundel'        => 'II',
        'page'          => rand(10 , 20),
        'status'        => 'available',
    ];
});

$factory->afterCreating(AreaCertificate::class, function (AreaCertificate $certificate) {
    for ($i = 1; $i < rand(2, 3); $i++) {
        $certificate->addMedia((new FileFactory)->create("certificate-{$certificate->id}.pdf", 10, 'application/pdf'))
            ->toMediaCollection('documents');
    }
});
