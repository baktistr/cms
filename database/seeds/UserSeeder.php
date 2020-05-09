<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create super admin users.
        $admins = collect([
            ['name' => 'Muh Ghazali Akbar', 'email' => 'muhghazaliakbar@icloud.com'],
            ['name' => 'Hanan Asyrawi', 'email' => 'hasyrawi@gmail.com'],
            ['name' => 'Super Admin', 'email' => 'superadmin@example.com'],
        ]);

        $admins->each(function ($admin) {
            factory(User::class)->state('super-admin')->create([
                'name'  => $admin['name'],
                'email' => $admin['email'],
            ]);
        });

        // Create admin users.
        factory(User::class, 5)->state('admin')->create();

        // Create user
        factory(User::class)->create([
            'name'  => 'Example User',
            'email' => 'user@example.com',
        ]);
    }
}
