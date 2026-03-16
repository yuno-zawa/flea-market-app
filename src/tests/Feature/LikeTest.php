<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    public function test_いいねアイコン押下で、いいねした商品として登録することができる()
    {
        $user = \App\Models\User::factory()->create();
        $item = \App\Models\Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/like");

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('<span class="like-count">1</span>', false);
    }

    public function test_追加済みのアイコンは色が変化する()
    {
        $user = \App\Models\User::factory()->create();
        $item = \App\Models\Item::factory()->create();

        \App\Models\Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('heart-pink.png', false);
    }

    public function test_再度いいねアイコン押下で、いいねを解除することができる()
    {
        $user = \App\Models\User::factory()->create();
        $item = \App\Models\Item::factory()->create();

        \App\Models\Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->post("/item/{$item->id}/like");

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('<span class="like-count">0</span>', false);
    }
}
