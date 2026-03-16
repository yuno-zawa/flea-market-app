<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;
    public function test_全商品を取得できる()
    {
        $item1 = Item::factory()->create(['name' => 'テスト商品1']);
        $item2 = Item::factory()->create(['name' => 'テスト商品2']);
        $item3 = Item::factory()->create(['name' => 'テスト商品3']);

        $response = $this->get('/');

        $response->assertSee('テスト商品1');
        $response->assertSee('テスト商品2');
        $response->assertSee('テスト商品3');
    }

    public function test_購入済商品はSoldと表示される()
    {
        $seller = \App\Models\User::factory()->create();
        $buyer = \App\Models\User::factory()->create();
        $item = Item::factory()->create(['user_id' => $seller->id]);

        Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都新宿区1-2-3',
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    public function test_自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の出品商品',
        ]);

        $response = $this->actingAs($user)->get('/');
        $response->assertDontSee('自分の出品商品');
    }
}
