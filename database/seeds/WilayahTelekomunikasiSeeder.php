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
        $witel = collect([
            'Banten',
            'Tangerang',
            'Jakarta Barat',
            'Jakarta Pusat',
            'Jakarta Selatan',
            'Jakarta Timur',
            'Jakarta Utara',
            'Bekasi',
            'Bogor',
        ]);

        $witel->each(function ($wilayah) {
            factory(WilayahTelekomunikasi::class)->create(['name' => $wilayah]);
        });
    }
}
