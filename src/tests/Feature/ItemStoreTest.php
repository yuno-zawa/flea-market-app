<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;
    public function test_商品出品画面にて必要な情報が保存できること()
{
    Storage::fake('public');

    $user = User::factory()->create();
    $category = Category::create([
    'name' => 'テストカテゴリ'
    ]);

    $data = [
        'name' => 'テスト商品',
        'brand' => 'テストブランド',
        'description' => 'テスト商品の説明です',
        'price' => 3000,
        'condition' => '新品',
        'categories' => [$category->id],
        'image' => UploadedFile::fake()->create('test.jpg', 100),
    ];

    $response = $this->actingAs($user)->post('/sell', $data);

    $response->assertRedirect();

    $this->assertDatabaseHas('items', [
        'name' => 'テスト商品',
        'brand' => 'テストブランド',
        'description' => 'テスト商品の説明です',
        'price' => 3000,
    ]);
}
}
