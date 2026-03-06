<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

    }
}
