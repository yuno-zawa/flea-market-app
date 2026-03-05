<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MylistTest extends TestCase
{
        use RefreshDatabase;
    public function test_いいねした商品だけが表示される()
    {
        $user = \App\Models\User::factory()->create();
        $item1 = \App\Models\Item::factory()->create([
            'name' => 'いいねした商品',
        ]);
        $item2 = \App\Models\Item::factory()->create([
            'name' => 'いいねしていない商品',
        ]);

        \App\Models\Like::create([
            'user_id' => $user->id,
            'item_id' => $item1->id,
        ]);
        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee($item1->name);
        $response->assertDontSee($item2->name);
    }

    public function test_購入済商品はSoldと表示される()
    {
        $seller = \App\Models\User::factory()->create();
        $buyer = \App\Models\User::factory()->create();
        $item = \App\Models\Item::factory()->create(['user_id' => $seller->id]);

        \App\Models\Purchase::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'カード払い',
            'postal_code' => '123-4567',
            'address' => '東京都新宿区1-2-3',
        ]);

        \App\Models\Like::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($buyer)->get('/?tab=mylist');

        $response->assertSee('Sold');

    }

    public function test_未認証の場合は何も表示されない(){
        $item = \App\Models\Item::factory()->create(['name' => 'いいねした商品']);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee($item->name);
    }
}
