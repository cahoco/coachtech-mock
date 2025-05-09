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

    /** @test */
    public function プロフィールページに必要な情報が表示される()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'name' => 'テスト太郎'
        ]);

        // プロフィール登録（画像含む）
        $profileImage = UploadedFile::fake()->image('profile.jpg');
        $profilePath = $profileImage->store('images', 'public');

        Profile::factory()->create([
            'user_id' => $user->id,
            'profile_image' => $profilePath,
        ]);

        // 出品商品2件
        $item1 = Item::factory()->create(['user_id' => $user->id, 'name' => '出品商品1']);
        $item2 = Item::factory()->create(['user_id' => $user->id, 'name' => '出品商品2']);

        // 購入商品（別ユーザーの商品を購入）
        $seller = User::factory()->create();
        $purchasedItem = Item::factory()->create(['user_id' => $seller->id, 'name' => '購入商品']);
        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id
        ]);

        // アクセスして情報を確認
        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
        $response->assertSee('出品商品1');
        $response->assertSee('出品商品2');
        $response->assertSee('購入商品');
        $response->assertSee($profilePath); // profile_imageのパスが含まれているか
    }
}
