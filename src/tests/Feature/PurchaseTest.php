<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 購入ボタンを押すと購入が完了する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'payment_method' => 'credit',
            'address_id' => 1, // ← 必須項目を追加（値は適当でOK）
            'zipcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル201',
        ]);

        $response->assertRedirect(route('orders.success', ['item_id' => $item->id]));
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 購入した商品は一覧画面でSoldと表示される()
    {
        // 出品者は「ダミー」として登録（← これが超重要！）
        $seller = User::factory()->create(['name' => 'ダミーユーザーA']);
        $item = Item::factory()->create(['user_id' => $seller->id]);

        // 購入者
        $buyer = User::factory()->create();

        Order::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'zipcode' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '青山ビル101',
            'payment_method' => 'クレジットカード',
        ]);

        // ログインした上でアクセス
        $response = $this->actingAs($buyer)->get('/');

        $response->assertSee('sold');
    }

    /** @test */
    public function 購入商品はプロフィールの購入一覧に表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 購入処理
        Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'zipcode' => '123-4567',
            'address' => '東京都',
            'building' => 'テストマンション101',
            'payment_method' => 'credit',
        ]);

        $response = $this->actingAs($user)->get('/mypage?tab=buy');

        $response->assertSee($item->name);
    }
}
