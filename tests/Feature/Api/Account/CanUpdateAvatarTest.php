<?php

namespace Tests\Feature\Api\Account;

use App\User;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CanUpdateAvatarTest extends TestCase
{
    /** @test */
    public function can_update_avatar_test()
    {
        $user = factory(User::class)->create();

        $imageFile = UploadedFile::fake()->image("user-avatar.jpg");

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/avatar', [
            'avatar' => $imageFile,
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function avatar_is_required()
    {
        $user = factory(User::class)->create();

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/avatar', [
            'avatar' => '',
        ]);

        $response->assertJsonValidationErrors('avatar');
    }

    /** @test */
    public function avatar_is_must_be_an_image()
    {
        $user = factory(User::class)->create();

        $notImageFile = UploadedFile::fake()->create("user-avatar.docx");

        Sanctum::actingAs($user);
        $response = $this->putJson('/api/account/avatar', [
            'avatar' => $notImageFile,
        ]);

        $response->assertJsonValidationErrors('avatar');
    }
}
