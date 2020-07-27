<?php

use App\WilayahTelekomunikasi;
use Illuminate\Database\Seeder;

class WilayahTelekomunikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = DatabaseSeeder::csvToArray(database_path('seeds/data/witel.csv'));

        foreach ($data as $witel) {
            WilayahTelekomunikasi::insert([
                'id'         => $witel[2],
                'name'       => $witel[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
