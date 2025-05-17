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

    public function test_登録した住所が商品購入画面に反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Profile::factory()->create([
            'user_id' => $user->id,
            'address' => '東京都港区1-1-1'
        ]);
        $response = $this->actingAs($user)->get(route('orders.confirm', [
            'item_id' => $item->id
        ]));
        $response->assertStatus(200);
        $response->assertSee('東京都港区1-1-1');
    }

    public function test_購入時に送付先住所が注文に紐づけられる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
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

