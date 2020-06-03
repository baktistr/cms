<?php

namespace Tests\Feature\Api\Asset;

use App\Asset;
use Laravel\Sanctum\Sanctum;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GetAllAssets extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function can_get_all_assets()
    {
        $user = factory(User::class)->create([
            'name'         => 'Old name',
            'email'        => 'old_email@example.com',
            'phone_number' => '+6285110374321',
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/assets/');

        $response->assertOk();
    }

    /**
     * @test
     */
    public function get_asset_without_login()
    {
        $response = $this->getJson('api/assets/');
        $response->assertUnauthorized();
    }
}
