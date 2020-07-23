<?php

use App\Area;
use App\AreaCertificate;
use App\AreaDisputeHistory;
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

            $areas = factory(Area::class, 10)->create([
                'telkom_regional_id' => $treg->id,
                'witel_id'           => $witel->id,
                'province_id'        => $regency->province->id,
                'regency_id'         => $regency->id,
                'district_id'        => null,
            ]);

            $areas->each(function ($area) {
                // Seed some certificates
                factory(AreaCertificate::class, rand(1, 2))->create([
                    'area_id' => $area->id
                ]);

                // Seed Some Asset dispute History
                factory(AreaDisputeHistory::class, rand(2, 3))->create([
                    'area_id' => $area->id
                ]);
            });
        }
    }
}
