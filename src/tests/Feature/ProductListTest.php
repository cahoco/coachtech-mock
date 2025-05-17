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

    public function test_全商品を取得できる()
    {
        $user = User::factory()->create(['name' => 'ダミーユーザー']);
        $items = Item::factory()->count(3)->for($user)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_購入済み商品はSoldと表示される()
    {
        $user = User::factory()->create(['name' => 'ダミー出品者']);
        $item = Item::factory()->for($user)->create();
        Order::factory()->create(['item_id' => $item->id]);
        $response = $this->get('/');
        $response->assertSee('sold');
    }

    public function test_自分が出品した商品は表示されない()
    {
        $loginUser = User::factory()->create(['name' => '本物ユーザー']);
        $ownItem = Item::factory()->for($loginUser)->create();
        $dummyUser = User::factory()->create(['name' => 'ダミー出品者']);
        $otherItem = Item::factory()->for($dummyUser)->create();
        $response = $this->actingAs($loginUser)->get('/');
        $response->assertSee($otherItem->name);
        $response->assertDontSee($ownItem->name);
    }

}
