<?php

use App\Building;
use App\BuildingEmployee;
use Illuminate\Database\Seeder;

class LocalBuildingEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::get()
            ->each(function ($building) {
                factory(BuildingEmployee::class, rand(3, 5))->create([
                    'building_id' => $building->id,
                ]);
            });
    }
}
