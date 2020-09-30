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

        $directors = collect([
            ['name' => 'Director 1', 'email' => 'director1@example.com'],
            ['name' => 'Director 2', 'email' => 'director2@example.com'],
        ]);


        $admins->each(function ($admin) {
            factory(User::class)->state('super-admin')->create([
                'name'  => $admin['name'],
                'email' => $admin['email'],
            ]);
        });

        // Create PIC users.
        factory(User::class, 5)->state('PIC')->create();

        factory(User::class)->state('building-manager')->create([
            'name'  => 'Manager',
            'email' => 'manager@example.com',
        ]);
        factory(User::class)->state('viewer')->create([
            'name'  => 'Viewer',
            'email' => 'viewer@example.com',
        ]);
        factory(User::class)->state('help-desk')->create([
            'name'  => 'Help Desk',
            'email' => 'helpdesk@example.com',
        ]);

        // Create Director users.
        $directors->each(function ($director) {
            factory(User::class)->state('director')->create([
                'name'  => $director['name'],
                'email' => $director['email'],
            ]);
        });
        // // Create user
        // factory(User::class, 100)->create();
    }
}
