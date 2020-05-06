<?php

use App\Regency;
use Illuminate\Database\Seeder;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regencies = file(database_path('seeds/locations/regency.csv'));

        foreach ($regencies as $regency) {
            $row = explode(',', $regency);

            factory(Regency::class)->create([
                'id'          => $row[0],
                'province_id' => $row[1],
                'name'        => str_replace(PHP_EOL, '', ucfirst(strtolower($row[2]))),
            ]);
        }
    }
}
