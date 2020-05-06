<?php

use App\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = file(database_path('seeds/locations/districs.csv'));

        foreach ($districts as $district) {
            $row = explode(',', $district);

            factory(District::class)->create([
                'id'         => $row[0],
                'regency_id' => $row[1],
                'name'       => str_replace(PHP_EOL, '', ucwords(strtolower($row[2]))),
            ]);
        }
    }
}
