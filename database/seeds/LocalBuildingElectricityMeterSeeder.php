<?php

use App\Building;
use App\BuildingDailyElectricityConsumption;
use App\BuildingElectricityConsumption;
use App\BuildingElectricityMeter;
use Illuminate\Database\Seeder;

class LocalBuildingElectricityMeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the generated buildings and seed the electricity meters.
        Building::get()->each(function ($building) {
            $buildingMeters = factory(BuildingElectricityMeter::class, rand(2, 4))->create([
                'building_id' => $building->id,
            ]);

            $electricMeter = 100;

            for ($i = 40; $i >= 1; $i--) {
                $electricityConsumption = factory(BuildingElectricityConsumption::class)->create([
                    'building_id' => $building->id,
                    'date'        => now()->subDays($i),
                ]);

                $buildingMeters->each(function ($buildingMeter) use ($electricityConsumption, $electricMeter) {
                    factory(BuildingDailyElectricityConsumption::class)->create([
                        'building_electricity_consumption_id' => $electricityConsumption->id,
                        'building_electricity_meter_id'       => $buildingMeter->id,
                        'electric_meter'                      => $electricMeter += $usage = rand(100, 500),
                        'lwbp'                                => $lwbp = rand(1, $usage),
                        'wbp'                                 => $usage - $lwbp,
                        'lwbp_rate'                           => 1000,
                        'wbp_rate'                            => 2000,
                    ]);
                });
            }
        });
    }
}
