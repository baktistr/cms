<?php

use App\Area;
use App\Regency;
use App\TelkomRegional;
use App\WilayahTelekomunikasi;
use Illuminate\Database\Seeder;

class LocalAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $treg = TelkomRegional::inRandomOrder()->first();
            $witel = WilayahTelekomunikasi::inRandomOrder()->first();
            $regency = Regency::with('province')->inRandomOrder()->first();

            factory(Area::class, 10)->create([
                'telkom_regional_id' => $treg->id,
                'witel_id'           => $witel->id,
                'province_id'        => $regency->province->id,
                'regency_id'         => $regency->id,
                'district_id'        => null,
            ]);
        }
    }
}
