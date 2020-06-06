<?php

namespace Tests\Feature\Api\Auth;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Default valid params for this test class.
     *
     * @param $params
     * @return array
     */
    private function validParams($params)
    {
        return array_merge([
            'email'       => 'user@example.com',
            'password'    => 'password',
            'device_name' => 'mobile',
        ], $params);
    }

    /** @test */
    public function can_login_using_email()
    {
        factory(User::class)->create(['email' => 'user@example.com']);

        $response = $this->postJson('/api/auth/login', [
            'email'       => 'user@example.com',
            'password'    => 'password',
            'device_name' => 'mobile',
        ]);

        $response->assertOk();
    }

    /** @test */
    public function can_login_using_username()
    {
        factory(User::class)->create(['username' => 'muhghazaliakbar']);

        $response = $this->postJson('/api/auth/login', [
            'email'       => 'muhghazaliakbar',
            'password'    => 'password',
            'device_name' => 'mobile',
        ]);

        $response->assertOk();
    }

    /** @test */
    public function email_is_required()
    {
        factory(User::class)->create(['email' => 'user@example.com']);

        $response = $this->postJson('/api/auth/login', $this->validParams([
            'email' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The email field is required.');
    }

    /** @test */
    public function email_is_string()
    {
        $response = $this->postJson('/api/auth/login', $this->validParams([
            'email' => 0000,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The email must be a string.');
    }

    /** @test */
    public function password_is_required()
    {
        $response = $this->postJson('/api/auth/login', $this->validParams([
            'password' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
        $response->assertJsonValidationErrorsMessage('password', 'The password field is required.');
    }

    /** @test */
    public function password_is_string()
    {
        $response = $this->postJson('/api/auth/login', $this->validParams([
            'password' => 0000,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
        $response->assertJsonValidationErrorsMessage('password', 'The password must be a string.');
    }

    /** @test */
    public function password_must_be_valid()
    {
        $user = factory(User::class)->create([
            'email' => 'user@example.com',
            'password' => Hash::make('valid_password')
        ]);

        $response = $this->postJson('/api/auth/login', $this->validParams([
            'email' => 'user@example.com',
            'password' => 'invalid_password',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The provided credentials are incorrect.');
    }

    /** @test */
    public function device_name_is_required()
    {
        $response = $this->postJson('/api/auth/login', $this->validParams([
            'device_name' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('device_name');
        $response->assertJsonValidationErrorsMessage('device_name', 'The device name field is required.');
    }

    /** @test */
    public function device_name_is_string()
    {
        $response = $this->postJson('/api/auth/login', $this->validParams([
            'device_name' => 0000,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('device_name');
        $response->assertJsonValidationErrorsMessage('device_name', 'The device name must be a string.');
    }
}
