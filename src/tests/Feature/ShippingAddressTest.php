<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 登録した住所が商品購入画面に反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // プロフィール（住所）を登録
        Profile::factory()->create([
            'user_id' => $user->id,
            'address' => '東京都港区1-1-1'
        ]);

        // 購入確認画面にアクセス
        $response = $this->actingAs($user)->get(route('orders.confirm', [
            'item_id' => $item->id
        ]));

        $response->assertStatus(200);
        $response->assertSee('東京都港区1-1-1'); // Bladeでaddressを表示している前提
    }

    /** @test */
    public function 購入時に送付先住所が注文に紐づけられる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // プロフィール登録
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'address' => '大阪府大阪市2-2-2'
        ]);

        $response = $this->actingAs($user)->post(route('orders.store', ['item_id' => $item->id]), [
            'payment_method' => 'convenience',
            'address_id' => 1,
        ]);

        $response->assertRedirect(route('orders.success', ['item_id' => $item->id]));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'address' => '大阪府大阪市2-2-2'
        ]);
    }

}

