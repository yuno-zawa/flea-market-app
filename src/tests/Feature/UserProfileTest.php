<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;
    public function test_必要なユーザー情報がすべて取得できる()
    {
        // ユーザーを作成
        $user = \App\Models\User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);
    }
}
