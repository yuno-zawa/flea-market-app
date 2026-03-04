<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_名前未入力時、バリデーションメッセージが表示される()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors('name');

        $response = $this->get('/register');

        $response->assertSee('お名前を入力してください');
    }

    public function test_メールアドレス未入力時、バリデーションメッセージが表示される()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '名前',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors('email');

        $response = $this->get('/register');

        $response->assertSee('メールアドレスを入力してください');
    }

    public function test_パスワード未入力時、バリデーションメッセージが表示される()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '名前',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors('password');

        $response = $this->get('/register');

        $response->assertSee('パスワードを入力してください');
    }

    public function test_パスワードが7文字以下の場合、バリデーションメッセージが表示される()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '名前',
            'email' => 'test@example.com',
            'password' => 'passwor',
            'password_confirmation' => 'passwor',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors('password');

        $response = $this->get('/register');

        $response->assertSee('パスワードは8文字以上で入力してください');
    }

    public function test_パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '名前',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password1',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors('password');

        $response = $this->get('/register');

        $response->assertSee('パスワードと一致しません');
    }

    public function test_全ての項目が正しく入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される()
    {
        $response = $this->post('/register', [
            'name' => '名前',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertRedirect('/mypage/profile');
        $this->assertDatabaseHas('users', [
            'name' => '名前',
            'email' => 'test@example.com',
        ]);
    }
}
