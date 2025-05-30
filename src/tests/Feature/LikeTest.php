<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログインユーザーが商品にいいねできる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post("/like/{$item->id}");
        $response->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_すでにいいねしている商品はアイコンの色が変わる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Like::create(['user_id' => $user->id, 'item_id' => $item->id]);
        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('like-button liked-icon');
    }

    public function test_いいねを解除できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Like::create(['user_id' => $user->id, 'item_id' => $item->id]);
        $response = $this->actingAs($user)->post("/like/{$item->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

}
