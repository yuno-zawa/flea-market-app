<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserProfileUpdateTest extends TestCase
{
    use RefreshDatabase;
    public function test_ユーザー情報の変更項目が初期値として過去設定されていること()
{
    $user = User::factory()->create([
        'name' => 'テストユーザー',
        'profile_image' => 'profile_images/test.jpg',
        'postal_code' => '1234567',
        'address' => '東京都渋谷区',
    ]);

    $response = $this->actingAs($user)->get('/mypage/profile');


    // 初期値が表示されていることを確認
    $response->assertSee('テストユーザー');
    $response->assertSee('test.jpg');
    $response->assertSee('1234567');
    $response->assertSee('東京都渋谷区');
}
}
