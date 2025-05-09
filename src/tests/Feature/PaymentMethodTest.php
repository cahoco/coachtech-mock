<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
    public function 支払い方法を選択すると表示が反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('orders.confirm', ['item_id' => $item->id]), [
            'payment_method' => 'bank',  // 支払い方法を送信
        ]);

        $response->assertStatus(200);
        $response->assertSee('銀行振込'); // Blade内に「銀行振込」などが表示される前提
    }

}
