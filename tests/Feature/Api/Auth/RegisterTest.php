<?php

namespace Tests\Feature\Api\Auth;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
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
            'password'     => 'my-password',
        ], $params);
    }

    /** @test */
    public function guest_can_register()
    {
        $response = $this->postJson('/api/auth/register', [
            'name'         => 'Muh Ghazali Akbar',
            'username'     => 'muhghazaliakbar',
            'email'        => 'muhghazaliakbar@live.com',
            'address'      => 'Jl. AP Pettarani Makassar',
            'phone_number' => '+6285110374321',
            'password'     => 'my-password',
        ]);

        $response->assertCreated();
        $response->assertStatus(201);
    }

    /** @test */
    public function name_is_required()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'name' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrorsMessage('name', 'The name field is required.');
    }

    /** @test */
    public function name_is_must_be_string()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'name' => 0000,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrorsMessage('name', 'The name must be a string.');
    }

    /** @test */
    public function name_length_can_not_be_more_than_255_chars()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'name' => Str::random(256),
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrorsMessage('name', 'The name may not be greater than 255 characters.');
    }

    /** @test */
    public function username_is_required()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'username' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
        $response->assertJsonValidationErrorsMessage('username', 'The username field is required.');
    }

    /** @test */
    public function username_is_must_be_alpha_num()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'username' => 'invalid-username',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
        $response->assertJsonValidationErrorsMessage('username', 'The username may only contain letters and numbers.');
    }

    /** @test */
    public function username_is_unique()
    {
        // Create user with username "muhghazaliakbar"
        factory(User::class)->create(['username' => 'muhghazaliakbar']);

        // Create user with same username we created before
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'username' => 'muhghazaliakbar',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('username');
        $response->assertJsonValidationErrorsMessage('username', 'The username has already been taken.');
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'email' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The email field is required.');
    }

    /** @test */
    public function email_is_must_be_string()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'email' => 0000,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The email must be a string.');
    }

    /** @test */
    public function phone_number_is_required()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'phone_number' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('phone_number');
        $response->assertJsonValidationErrorsMessage('phone_number', 'The phone number field is required.');
    }

    /** @test */
    public function email_length_can_not_be_more_than_255_chars()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'email' => Str::random(256),
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The email may not be greater than 255 characters.');
    }

    /** @test */
    public function email_is_must_be_an_email()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'email' => 'invalid-email',
        ]));


        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The email must be a valid email address.');
    }

    /** @test */
    public function email_is_must_be_real_email()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'email' => 'fake-238r79238.com',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrorsMessage('email', 'The email must be a valid email address.');
    }

    /** @test */
    public function password_is_required()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'password' => '',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
        $response->assertJsonValidationErrorsMessage('password', 'The password field is required.');
    }

    /** @test */
    public function password_length_is_more_than_8_chars()
    {
        $response = $this->postJson('/api/auth/register', $this->validParams([
            'password' => 'qwerty',
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
        $response->assertJsonValidationErrorsMessage('password', 'The password must be at least 8 characters.');
    }
}
