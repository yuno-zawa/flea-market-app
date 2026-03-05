<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;
    public function test_商品名で部分一致検索ができる()
    {
        $item1 = \App\Models\Item::factory()->create(['name' => 'テスト商品']);
        $item2 = \App\Models\Item::factory()->create(['name' => '別の商品']);

        $response = $this->get('/?keyword=テスト');

        $response->assertSee($item1->name);
        $response->assertDontSee($item2->name);
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=テスト');

        $response->assertSee('テスト');
    }
}
