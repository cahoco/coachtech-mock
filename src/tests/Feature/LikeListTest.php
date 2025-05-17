<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeListTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねした商品だけが表示される()
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create([
            'user_id' => User::factory()->create()->id,
            'name' => 'いいね商品'
        ]);
        $notLikedItem = Item::factory()->create([
            'user_id' => User::factory()->create()->id,
            'name' => 'いいねしてない商品'
        ]);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee('いいね商品');
        $response->assertDontSee('いいねしてない商品');
    }

    public function test_購入済み商品はSoldと表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);
        Order::factory()->create(['item_id' => $item->id]);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee('sold');
    }

    public function test_自分が出品した商品は表示されない()
    {
        $user = User::factory()->create();
        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品'
        ]);
        $otherItem = Item::factory()->create([
            'name' => '他人の商品'
        ]);
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $ownItem->id]);
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $otherItem->id]);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee('他人の商品');
        $response->assertDontSee('自分の商品');
    }

    public function test_未認証の場合は何も表示されない()
    {
        $item = Item::factory()->create();
        Like::factory()->create(['item_id' => $item->id]);
        $response = $this->get('/?tab=mylist');
        $response->assertDontSee($item->name);
    }

}
