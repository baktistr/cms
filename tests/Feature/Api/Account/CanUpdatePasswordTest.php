<?php

namespace Tests\Feature\Api\Account;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CanUpdatePasswordTest extends TestCase
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
            'old_password'              => 'old-password',
            'new_password'              => 'new-password',
            'new_password_confirmation' => 'new-password',
        ], $params);
    }

    /** @test */
    public function can_update_account_password()
    {
        $user = factory(User::class)->create(['password' => Hash::make('old-password')]);

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/password', [
            'old_password'              => 'old-password',
            'new_password'              => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertStatus(201);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    /** @test */
    public function guest_can_not_update_account_password()
    {
        $response = $this->putJson('/api/account/password', $this->validParams());

        $response->assertStatus(401);
    }

    /** @test */
    public function old_password_field_is_required()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/password', $this->validParams([
            'old_password' => '',
        ]));

        $response->assertJsonValidationErrors('old_password');
    }

    /** @test */
    public function old_password_field_is_must_be_same_with_old_password()
    {
        $user = factory(User::class)->create(['password' => Hash::make('old-password')]);

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/password', $this->validParams([
            'old_password' => 'different-old-password',
        ]));

        $response->assertJsonValidationErrors('old_password');
    }

    /** @test */
    public function password_field_is_required()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/password', $this->validParams([
            'new_password' => '',
        ]));

        $response->assertJsonValidationErrors('new_password');
    }

    /** @test */
    public function password_field_is_more_than_6_characters()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/password', $this->validParams([
            'new_password' => '12345',
        ]));

        $response->assertJsonValidationErrors('new_password');
    }
}
