<?php

use App\Building;
use App\BuildingWaterConsumption;
use Illuminate\Database\Seeder;

class LocalBuildingWaterConsumptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the generated buildings from other seeder and seed the wate consumptions.
        Building::get()
            ->each(function ($building) {
                $usage = 100;

                for ($i = 1; $i <= rand(10, 30); $i++) {
                    factory(BuildingWaterConsumption::class)->create([
                        'building_id' => $building->id,
                        'date'        => now()->addDays($i),
                        'usage'       => $usage += 100,
                        'rate'        => 1000,
                    ]);
                }
            });
    }
}
