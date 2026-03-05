<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;
    public function test_商品詳細の必要な情報がすべて表示される()
    {
        $item = \App\Models\Item::factory()->create([
            'user_id' => \App\Models\User::factory()->create()->id,
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明',
            'price' => 1000,
            'brand' => 'テストブランド',
            'condition' => '良好',
        ]);

        $category = \App\Models\Category::create(['name' => 'テストカテゴリ']);
        $item->categories()->attach($category->id);

// いいねを作る
        \App\Models\Like::create([
            'user_id' => $item->user_id,
            'item_id' => $item->id,
        ]);

        $commenter = \App\Models\User::factory()->create(['name' => 'コメントユーザー']);
        \App\Models\Comment::create([
            'user_id' => $commenter->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
            ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('テスト商品');
        $response->assertSee('テスト商品の説明');
        $response->assertSee('1,000');
        $response->assertSee('テストブランド');
        $response->assertSee('良好');
        $response->assertSee('テストカテゴリ');
        $response->assertSee('コメントユーザー');
        $response->assertSee('テストコメント');
    }

    public function test_複数選択されたカテゴリが表示される()
    {
        $item = \App\Models\Item::factory()->create([
            'user_id' => \App\Models\User::factory()->create()->id,
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明',
            'price' => 1000,
            'brand' => 'テストブランド',
            'condition' => '良好',
        ]);

        $category1 = \App\Models\Category::create(['name' => 'テストカテゴリ1']);
        $category2 = \App\Models\Category::create(['name' => 'テストカテゴリ2']);
        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('テスト商品');
        $response->assertSee('テスト商品の説明');
        $response->assertSee('1,000');
        $response->assertSee('テストブランド');
        $response->assertSee('良好');
        $response->assertSee('テストカテゴリ1');
        $response->assertSee('テストカテゴリ2');
    }
}