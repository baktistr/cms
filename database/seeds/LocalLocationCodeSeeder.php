<?php

use App\LocationCode;
use Illuminate\Database\Seeder;

class LocalLocationCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(LocationCode::class, 10)->create();
    }
}
