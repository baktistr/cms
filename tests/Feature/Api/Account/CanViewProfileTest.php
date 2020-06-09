<?php

namespace Tests\Feature\Api\Account;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CanViewProfileTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_see_auth_user_profile()
    {
        $user = factory(User::class)->create([
            'name'         => 'Muh Ghazali Akbar',
            'email'        => 'muhghazaliakbar@live.com',
            'phone_number' => '+6285110374321',
        ]);

        Sanctum::actingAs($user);
        $response = $this->getJson('/api/account/profile');

        $response->assertJsonFragment([
            'name'         => 'Muh Ghazali Akbar',
            'email'        => 'muhghazaliakbar@live.com',
            'phone_number' => '+6285110374321',
            'avatar'       => [
                'tiny'   => $user->getFirstMediaUrl('avatar', 'tiny'),
                'small'  => $user->getFirstMediaUrl('avatar', 'small'),
                'medium' => $user->getFirstMediaUrl('avatar', 'medium'),
                'large'  => $user->getFirstMediaUrl('avatar', 'large'),
            ],
        ]);
    }
}
