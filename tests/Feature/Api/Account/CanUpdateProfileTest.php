<?php

namespace Tests\Feature\Api\Account;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CanUpdateProfileTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Default valid params for this test class.
     *
     * @param $params
     * @return array
     */
    private function validParams($params = [])
    {
        return array_merge([
            'name'         => 'Muh Ghazali Akbar',
            'username'     => 'muhghazaliakbar',
            'email'        => 'muhghazaliakbar@live.com',
            'address'      => 'Jl. AP Pettarani Makassar',
            'phone_number' => '+6285110374321',
        ], $params);
    }

    /** @test */
    public function can_update_profile_detail()
    {
        $user = factory(User::class)->create([
            'name'         => 'Old name',
            'username'     => 'muhghazaliakbar',
            'email'        => 'old_email@example.com',
            'phone_number' => '+6285110374321',
        ]);

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', [
            'name'         => 'New name',
            'username'     => 'newuniqueusername',
            'email'        => 'new_email@example.com',
            'phone_number' => '+6285971718998',
        ]);

        $response->assertJsonFragment([
            'name'         => 'New name',
            'email'        => 'new_email@example.com',
            'phone_number' => '+6285971718998',
        ]);
    }

    /** @test */
    public function update_profile_email_ignore_itself()
    {
        $user = factory(User::class)->create([
            'email' => 'ignore_me@example.com',
        ]);

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'email' => 'ignore_me@example.com',
        ]));

        $response->assertOk();
        $response->assertJsonFragment(['email' => 'ignore_me@example.com']);
    }

    /** @test */
    public function name_is_required()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'name' => '',
        ]));

        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function name_is_must_be_string()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'name' => 112132,
        ]));

        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function username_is_required()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'username' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
    }

    /** @test */
    public function username_is_must_be_alpha_num()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'username' => 'invalid-username',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
    }

    /** @test */
    public function username_is_unique()
    {
        $user1 = factory(User::class)->create(['username' => 'muhghazaliakbar']);
        $user2 = factory(User::class)->create(['username' => 'otherusername']);

        Sanctum::actingAs($user1);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'username' => 'otherusername',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
    }

    /** @test */
    public function username_is_unique_but_ignore_itself()
    {
        // Create user with username "muhghazaliakbar"
        $user = factory(User::class)->create(['username' => 'muhghazaliakbar']);

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'username' => 'muhghazaliakbar',
        ]));

        $response->assertOk();
    }

    /** @test */
    public function email_is_required()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'email' => '',
        ]));

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_is_must_be_an_email()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'email' => 'invalid_email',
        ]));

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_is_must_be_a_valid_email()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'email' => 'invalid_email_format@example',
        ]));

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_is_unique()
    {
        $user1 = factory(User::class)->create(['email' => 'duplicate_email@example.com']);
        $user2 = factory(User::class)->create(['email' => 'muhghazaliakbar@live.com']);

        Sanctum::actingAs($user2);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'email' => 'duplicate_email@example.com',
        ]));

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_is_unique_but_ignore_itself()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'ignore_me@example.com',
        ]);

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'email' => 'ignore_me@example.com',
        ]));

        $response->assertOk();
        $response->assertJsonFragment([
            'email' => 'ignore_me@example.com',
        ]);
    }

    /** @test */
    public function phone_number_is_required()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'phone_number' => '',
        ]));

        $response->assertJsonValidationErrors('phone_number');
    }

    /** @test */
    public function phone_number_is_must_be_valid_phone_number()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'phone_number' => 'invalid-phone-number',
        ]));

        $response->assertJsonValidationErrors('phone_number');
    }

    /** @test */
    public function phone_number_is_must_be_indonesian_phone_number()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/profile', $this->validParams([
            'phone_number' => '+1885885885',
        ]));

        $response->assertJsonValidationErrors('phone_number');
    }
}
