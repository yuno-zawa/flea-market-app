<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_必要なユーザー情報がすべて取得できる()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profile_images/test.jpg',
        ]);

        // 出品した商品
        $listedItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品した商品',
        ]);

        // 別ユーザーが出品した商品を購入
        $seller = User::factory()->create();
        $purchasedItem = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入した商品',
        ]);
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
            'payment_method' => 'card',
            'postal_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee('テストユーザー');
        $response->assertSee('profile_images/test.jpg');
        $response->assertSee('出品した商品');
        $response->assertSee('購入した商品');
    }
}