<?php

use App\User;
use Illuminate\Database\Seeder;

class ProductionUserSeeder extends Seeder
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
            ['name' => 'Super Admin 1', 'email' => 'superadmin1@cms.irent.id'],
            ['name' => 'Super Admin 2', 'email' => 'superadmin2@cms.irent.id'],
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

        $directors->each(function ($director) {
            factory(User::class)->state('director')->create([
                'name'  => $director['name'],
                'email' => $director['email'],
            ]);
        });

    }
}
