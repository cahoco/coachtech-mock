<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品名で部分一致検索ができる()
    {
        $user = User::factory()->create(['name' => 'ダミーユーザー']);
        Item::factory()->create([
            'name' => 'テスト商品A',
            'user_id' => $user->id,
        ]);
        Item::factory()->create([
            'name' => '別の商品',
            'user_id' => $user->id,
        ]);
        $response = $this->get('/?keyword=テスト');
        $response->assertSee('テスト商品A');
        $response->assertDontSee('別の商品');
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();
        $item1 = Item::factory()->create(['name' => 'カメラバッグ']);
        $item2 = Item::factory()->create(['name' => 'スニーカー']);
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $item1->id]);
        Like::factory()->create(['user_id' => $user->id, 'item_id' => $item2->id]);
        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=カメラ');
        $response->assertSee('カメラバッグ');
        $response->assertDontSee('スニーカー');
    }

}
