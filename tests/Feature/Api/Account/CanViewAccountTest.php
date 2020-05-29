<?php

namespace Tests\Feature\Api\Account;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CanViewAccountTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_see_auth_user_detail()
    {
        $user = factory(User::class)->create([
            'name'  => 'Muh Ghazali Akbar',
            'email' => 'muhghazaliakbar@live.com',
        ]);

        Sanctum::actingAs($user);
        $response = $this->getJson('/api/account');

        $response->assertJsonFragment([
            'name'  => 'Muh Ghazali Akbar',
            'email' => 'muhghazaliakbar@live.com',
        ]);
    }
}
