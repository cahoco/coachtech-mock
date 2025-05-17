<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_支払い方法を選択すると表示が反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Profile::factory()->create([
            'user_id' => $user->id,
            'nickname' => 'テスト太郎',
            'zipcode' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'ビル101',
        ]);
        $response = $this->actingAs($user)->get(
            route('orders.confirm', [
                'item_id' => $item->id,
                'payment_method' => 'credit',
            ])
        );
        $response->assertStatus(200);
        $response->assertSee('カード払い');
    }

}
