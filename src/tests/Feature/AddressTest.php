<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Purchase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class AddressTest extends TestCase
{
    use RefreshDatabase;
    public function test_送付先住所変更画面で登録した住所が購入画面に反映されている()
    {
        $user = \App\Models\User::factory()->create([
            'postal_code' => '000-0000',
            'address' => '元の住所',
        ]);
        $item = \App\Models\Item::factory()->create();

        $this->actingAs($user)->post("/purchase/address/{$item->id}", [
            'postal_code' => '123-4567',
            'address' => '東京都新宿区西新宿2-8-1',
            'building' => '新宿ビル10F',
        ]);

        $response = $this->actingAs($user)->get("/purchase/{$item->id}");
        $response->assertSee('123-4567');
        $response->assertSee('東京都新宿区西新宿2-8-1');
        $response->assertSee('新宿ビル10F');
    }

    public function test_購入した商品に送付先住所が紐づいて登録される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->withSession([
            'purchase_item_id' => $item->id,
            'purchase_payment_method' => 'card',
            'purchase_shipping' => [
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
            ],
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);
    }
}
