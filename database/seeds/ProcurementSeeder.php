<?php

use App\BuildingProcurement;
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
       factory(BuildingProcurement::class , 10)->create();
    }
}
