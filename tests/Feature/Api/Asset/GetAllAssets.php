<?php

namespace Tests\Feature\Api\Asset;

use App\Building;
use Laravel\Sanctum\Sanctum;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllAssets extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_get_all_assets()
    {

        $user = factory(User::class)->create([
            'name'         => 'Old name',
            'email'        => 'old_email@example.com',
            'phone_number' => '+6285110374321',
        ]);

        $user = User::first();
        Sanctum::actingAs($user);
        $response = $this->getJson('api/assets/');
        $response
            ->assertJsonFragment(["data" => []])
            ->assertOk();
    }
    /**
     * @test
     */
    public function get_filter_asset()
    {
        $user = factory(User::class)->create([
            'name'         => 'Old name',
            'email'        => 'old_email@example.com',
            'phone_number' => '+6285110374321',
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/assets/filter?category=tanah');


        $response
            ->assertJsonFragment(["data" => []])
            ->assertOk();
    }
    /**
     * @test
     */
    public function get_search_asset()
    {
        $user = factory(User::class)->create([
            'name'         => 'Old name',
            'email'        => 'old_email@example.com',
            'phone_number' => '+6285110374321',
        ]);

        $user = User::first();
        Sanctum::actingAs($user);

        $response = $this->getJson('api/assets/search?search=ad');
        $response
            ->assertJsonFragment(["data" => []])
            ->assertOk();
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
