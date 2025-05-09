<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得できる()
    {
        Item::factory()->count(3)->create();

        $response = $this->get('/'); // 商品一覧ページ

        $response->assertStatus(200);
        $items = Item::all();
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    /** @test */
    public function 購入済み商品はSoldと表示される()
    {
        $item = Item::factory()->create();
        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        $ownItem = Item::factory()->create(['user_id' => $user->id]);
        $otherItem = Item::factory()->create(); // 別の出品者の商品

        $response = $this->actingAs($user)->get('/');

        $response->assertSee($otherItem->name);
        $response->assertDontSee($ownItem->name);
    }
}
