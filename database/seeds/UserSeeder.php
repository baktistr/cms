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
        /**
         * Create admin users
         */
        factory(User::class)->state('admin')->create([
            'name'  => 'Muh Ghazali Akbar',
            'email' => 'muhghazaliakbar@icloud.com',
        ]);
    }
}
