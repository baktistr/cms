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
            'Jakbar',
            'Jakpus',
            'Jaksel',
            'Jaktim',
            'Jakut',
            'Bekasi',
            'Bogor',
        ]);

        $witel->each(function ($wilayah) {
            factory(WilayahTelekomunikasi::class)->create(['name' => $wilayah]);
        });
    }
}
