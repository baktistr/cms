<?php

namespace Tests\Feature\Auth;

use App\Notifications\Auth\EmailVerificationNotification;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerificationEmailTest extends TestCase
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
            'name'                  => 'Muh Ghazali Akbar',
            'email'                 => 'muhghazaliakbar@live.com',
            'password'              => 'my-password',
            'password_confirmation' => 'my-password',
        ], $params);
    }

    /** @test */
    public function can_send_verification_email()
    {
        Notification::fake();

        $this->postJson('/api/auth/register', $this->validParams());

        $user = User::latest()->first();

        Notification::assertSentTo([$user], EmailVerificationNotification::class);
    }

    /** @test */
    public function can_verify_account()
    {
        $this->markTestSkipped();
        $user = factory(User::class)->state('unverified')->create();
    }

    public function can_not_verify_account_with_wrong_code()
    {
        
    }
}
