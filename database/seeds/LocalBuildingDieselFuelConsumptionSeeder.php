<?php

use App\Building;
use App\BuildingDieselFuelConsumption;
use Illuminate\Database\Seeder;

class LocalBuildingDieselFuelConsumptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the generated buildings from other seeder and seed the electricity consumptions.
        Building::get()
            ->each(function ($building) {
                factory(BuildingDieselFuelConsumption::class)->create([
                    'building_id' => $building->id,
                    'type'        => 'incoming',
                    'date'        => now()->addDays(1),
                    'amount'      => 300,
                ]);

                factory(BuildingDieselFuelConsumption::class)->create([
                    'building_id' => $building->id,
                    'type'        => 'remain',
                    'date'        => now()->addDays(2),
                    'amount'      => 50,
                ]);

                factory(BuildingDieselFuelConsumption::class)->create([
                    'building_id' => $building->id,
                    'type'        => 'remain',
                    'date'        => now()->addDays(3),
                    'amount'      => 120,
                ]);

                factory(BuildingDieselFuelConsumption::class)->create([
                    'building_id' => $building->id,
                    'type'        => 'incoming',
                    'date'        => now()->addDays(4),
                    'amount'      => 100,
                ]);
            });
    }
}
