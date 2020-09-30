<?php

namespace Tests\Feature\Api\Auth;

use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Get valid token for reset password.
     *
     * @param $user
     * @return mixed
     */
    protected function getValidToken($user)
    {
        return Password::broker()->createToken($user);
    }

    /**
     * Get invalid token for reset password.
     *
     * @return string
     */
    protected function getInvalidToken()
    {
        return 'invalid-token';
    }

    protected function passwordResetGetRoute($token)
    {
        return route('password.reset', $token);
    }

    protected function passwordResetPostRoute()
    {
        return '/password/reset';
    }

    protected function successfulPasswordResetRoute()
    {
        return route('home');
    }

    /** @test */
    public function can_view_a_reset_password_form()
    {
        $user = factory(User::class)->create();

        $response = $this->get($this->passwordResetGetRoute($token = $this->getValidToken($user)));

        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.reset');
        $response->assertViewHas('token', $token);
    }

    /** @test */
    public function can_reset_password()
    {
        Event::fake();

        $user = factory(User::class)->create();

        $response = $this->post($this->passwordResetPostRoute(), [
            'token'                 => $this->getValidToken($user),
            'email'                 => $user->email,
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect($this->successfulPasswordResetRoute());

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(PasswordReset::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    /** @test */
    public function can_not_reset_password_with_invalid_token()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->from($this->passwordResetGetRoute($this->getInvalidToken()))
            ->post($this->passwordResetPostRoute(), [
                'token'                 => $this->getInvalidToken(),
                'email'                 => $user->email,
                'password'              => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertRedirect($this->passwordResetGetRoute($this->getInvalidToken()));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function email_is_required()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->from($this->passwordResetGetRoute($token = $this->getValidToken($user)))
            ->post($this->passwordResetPostRoute(), [
                'token'                 => $token,
                'email'                 => '',
                'password'              => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response->assertRedirect($this->passwordResetGetRoute($token));
        $response->assertSessionHasErrors('email');

        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function password_is_required()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->from($this->passwordResetGetRoute($token = $this->getValidToken($user)))
            ->post($this->passwordResetPostRoute(), [
                'token'                 => $token,
                'email'                 => $user->email,
                'password'              => '',
                'password_confirmation' => '',
            ]);

        $response->assertRedirect($this->passwordResetGetRoute($token));
        $response->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function password_must_be_confirmed()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->from($this->passwordResetGetRoute($token = $this->getValidToken($user)))
            ->post($this->passwordResetPostRoute(), [
                'token'                 => $token,
                'email'                 => $user->email,
                'password'              => 'new-password',
                'password_confirmation' => 'new-different-password',
            ]);

        $response->assertRedirect($this->passwordResetGetRoute($token));
        $response->assertSessionHasErrors('password');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }
}
