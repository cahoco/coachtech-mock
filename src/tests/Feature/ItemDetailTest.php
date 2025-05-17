<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品詳細に必要な情報が表示される()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create(['name' => '新品']);
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'price' => 12345,
            'description' => 'これは説明文です',
            'condition_id' => $condition->id,
            'brand' => 'ブランドA',
            'image' => 'storage/images/sample.jpg',
        ]);
        $category1 = Category::factory()->create(['name' => 'カテゴリ1']);
        $category2 = Category::factory()->create(['name' => 'カテゴリ2']);
        $item->categories()->attach([$category1->id, $category2->id]);
        Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'コメント本文です',
        ]);
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('テスト商品');
        $response->assertSee('¥12,345');
        $response->assertSee('ブランドA');
        $response->assertSee('新品');
        $response->assertSee('これは説明文です');
        $response->assertSee('カテゴリ1');
        $response->assertSee('カテゴリ2');
        $response->assertSee('コメント本文です');
        $response->assertSee($user->name);
    }

}
