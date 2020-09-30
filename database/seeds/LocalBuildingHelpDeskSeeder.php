<?php

use App\Building;
use App\BuildingHelpDesk;
use App\BuildingHelpDeskCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LocalBuildingHelpDeskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randomCategory = BuildingHelpDeskCategory::pluck('id')->toArray();

        Building::get()
            ->each(function ($building) use ($randomCategory) {
                $helpDesks = $building->helpdesks()->pluck('id')->toArray();

                factory(BuildingHelpDesk::class)->create([
                    'help_desk_category_id' => Arr::random($randomCategory),
                    'building_id'           => $building->id,
                    'help_desk_id'          => Arr::random($helpDesks),
                ]);
            });
    }
}
