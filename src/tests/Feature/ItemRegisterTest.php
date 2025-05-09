<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemRegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 出品フォームから商品情報を登録できる()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $response = $this->actingAs($user)->post('/items/register', [
            'name' => 'テスト商品',
            'description' => 'これはテスト商品です',
            'category_id' => $category->id,
            'condition_id' => $condition->id,
            'price' => 2000,
            'image' => UploadedFile::fake()->image('item.jpg'),
        ]);

        $response->assertRedirect('/'); // 商品一覧などリダイレクト先に応じて調整

        // items テーブルには category_id は無いので削除
        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => 'これはテスト商品です',
            'condition_id' => $condition->id,
            'price' => 2000,
            'user_id' => $user->id,
        ]);

        // 中間テーブルにカテゴリが登録されていることを確認
        $this->assertDatabaseHas('category_item', [
            'item_id' => Item::where('name', 'テスト商品')->first()->id,
            'category_id' => $category->id,
        ]);

        // 画像が保存されていること
        $item = Item::first();
        $path = str_replace('storage/', '', $item->image);
        Storage::disk('public')->assertExists($path);

    }
}
