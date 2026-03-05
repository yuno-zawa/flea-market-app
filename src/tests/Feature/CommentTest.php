<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    public function test_ログイン済みのユーザーはコメントを送信できる()
    {
        $user = \App\Models\User::factory()->create();
        $item = \App\Models\Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'テストコメント',
        ]);
    }
}
