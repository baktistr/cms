<?php

use Illuminate\Database\Seeder;
use App\Province ;
class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = file(database_path('seeds/locations/province.csv'));

        foreach ($provinces as $province) {
            $row = explode(',', $province);

            factory(Province::class)->create([
                'id' => $row[0],
                'name' => str_replace(PHP_EOL, '', ucfirst(strtolower($row[1]))),
            ]);
        }
    }
}
