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

    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        $item = \App\Models\Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_コメント未入力時、バリデーションメッセージが表示される()
    {
        $user = \App\Models\User::factory()->create();
        $item = \App\Models\Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_コメントが255文字以上の場合、バリデーションメッセージが表示される()
    {
        $user = \App\Models\User::factory()->create();
        $item = \App\Models\Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors('content');
    }
}
