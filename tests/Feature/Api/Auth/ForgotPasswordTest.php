<?php

namespace Tests\Feature\Api\Auth;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_send_reset_link_to_email()
    {
        Notification::fake();

        factory(User::class)->create(['email' => 'muhghazaliakbar@live.com']);

        $response = $this->postJson('/api/auth/password/email', [
            'email' => 'muhghazaliakbar@live.com',
        ]);

        $response->assertOk();
        $response->assertJson(['message' => 'We have emailed your password reset link!']);
    }

    /** @test */
    public function can_send_email_reset_password_link()
    {
        Notification::fake();

        $user = factory(User::class)->create(['email' => 'muhghazaliakbar@live.com']);

        $this->postJson('/api/auth/password/email', [
            'email' => 'muhghazaliakbar@live.com',
        ]);

        $this->assertNotNull($token = DB::table('password_resets')->first());

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }

    /** @test */
    public function can_not_reset_link_when_email_is_not_registered()
    {
        $response = $this->postJson('/api/auth/password/email', [
            'email' => 'notregistered@email.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorsMessage('email', 'We can\'t find a user with that email address.');
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->postJson('/api/auth/password/email', [
            'email' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorsMessage('email', 'The email field is required.');
    }

    /** @test */
    public function email_must_be_a_valid_email_address()
    {
        $response = $this->postJson('/api/auth/password/email', [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorsMessage('email', 'The email must be a valid email address.');
    }
}
