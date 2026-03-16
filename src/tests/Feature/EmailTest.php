<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_メール認証メールが送信される()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->actingAs($user)->post(route('verification.send'))
            ->assertSessionHas('message', '認証メールを再送しました。');
    }

    public function test_認証メールのリンクを押すとメール認証サイトに遷移する()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)->get($verificationUrl)
            ->assertRedirect(route('profile.edit'));
    }
    public function test_メール認証を完了するとプロフィール設定画面に遷移する()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)->get($verificationUrl)
            ->assertRedirect(route('profile.edit'));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}