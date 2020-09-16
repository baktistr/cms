<?php

use App\Procurement;
use Illuminate\Database\Seeder;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(Procurement::class , 10)->create();
    }
}
