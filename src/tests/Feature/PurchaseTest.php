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
            'shipping_address' => '東京都渋谷区1-1-1',
        ]);

        $response->assertRedirect('/'); // 購入完了後の遷移先に応じて変更
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 購入した商品は一覧画面でSoldと表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 購入処理
        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'zipcode' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '青山ビル101',
            'payment_method' => 'クレジットカード',
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
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
            'payment_method' => 'credit',
            'shipping_address' => '東京都',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee($item->name);
    }
}
