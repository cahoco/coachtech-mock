<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_プロフィールページに必要な情報が表示される()
    {
        Storage::fake('public');
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
        ]);
        $profilePath = 'images/test.jpg';
        $user->profile()->create([
            'nickname' => 'テスト太郎',
            'zipcode' => '123-4567',
            'address' => '東京都港区',
            'building' => 'テストビル101',
            'profile_image' => $profilePath,
        ]);
        $item1 = Item::factory()->create(['name' => '出品商品1', 'user_id' => $user->id]);
        $item2 = Item::factory()->create(['name' => '出品商品2', 'user_id' => $user->id]);
        $response = $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
        $response->assertSee('出品商品1');
        $response->assertSee('出品商品2');
        $response->assertSee('購入した商品');
        $response->assertSee($profilePath);
    }

}
