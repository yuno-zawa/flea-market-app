<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_error_message_is_displayed_when_registering()
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
}
