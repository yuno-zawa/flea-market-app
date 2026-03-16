<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_メールアドレス未入力時、バリデーションメッセージが表示される()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => '12345678',
        ]);

        $response->assertRedirect('/login');

        $response->assertSessionHasErrors('email');

        $response = $this->get('/login');

        $response->assertSee('メールアドレスを入力してください');
    }

    public function test_パスワード未入力時、バリデーションメッセージが表示される()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertRedirect('/login');

        $response->assertSessionHasErrors('password');

        $response = $this->get('/login');

        $response->assertSee('パスワードを入力してください');
    }

    public function test_入力情報が間違っている場合、バリデーションメッセージが表示される()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');

        $response->assertSessionHasErrors('email');

        $response = $this->get('/login');

        $response->assertSee('ログイン情報が登録されていません');
    }

        public function test_正しい情報が入力されたとき、ログイン処理が実行される()
        {
            $user = \App\Models\User::factory()->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

            $response = $this->from('/login')->post('/login', [
                'email' => 'test@example.com',
                'password' => 'password',
            ]);

            $response->assertRedirect('/');
            $this->assertAuthenticatedAs($user);
        }
}