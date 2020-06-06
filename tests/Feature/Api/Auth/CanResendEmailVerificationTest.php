<?php

namespace Tests\Feature\Api\Auth;

use App\Notifications\Auth\EmailVerificationNotification;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CanResendEmailVerificationTest extends TestCase
{
    /** @test */
    public function can_resend_verification_email()
    {
        Notification::fake();

        $user = factory(User::class)->state('unverified')->create();

        $response = $this->postJson('/api/auth/verify/resend', [
            'user' => $user->id,
        ]);

        Notification::assertSentTo([$user], EmailVerificationNotification::class);

        $response->assertStatus(202);
        $response->assertExactJson(['message' => 'The email verification link has been sent.']);
    }

    /** @test */
    public function verified_user_will_receive_notif_that_already_verified()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $response = $this->postJson('/api/auth/verify/resend', [
            'user' => $user->id,
        ]);

        Notification::assertNotSentTo([$user], EmailVerificationNotification::class);

        $response->assertOk();
        $response->assertExactJson(['message' => 'Your account has been verified.']);
    }
}
