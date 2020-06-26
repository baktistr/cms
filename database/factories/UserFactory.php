<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Testing\File;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'username'          => $faker->unique()->userName,
        'email'             => $faker->unique()->safeEmail,
        'phone_number'      => '+6285110374321',
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
        'address'           => $faker->optional()->streetAddress,
    ];
});

$factory->state(User::class, 'unverified', ['email_verified_at' => null]);

$factory->state(User::class, 'super-admin', []);

$factory->state(User::class, 'PIC', []);


$factory->afterCreatingState(User::class , 'PIC' , function(User $user){
    $user->assignRole('PIC');
});

$factory->afterCreatingState(User::class , 'super-admin' , function(User $user){
    $user->assignRole('Super Admin');
});

$factory->afterCreating(User::class, function (User $user) {
    // Add avatar image to factory.
    $user->addMedia(File::image("asset-{$user->id}-image.png"))
        ->toMediaCollection('avatar');
});
