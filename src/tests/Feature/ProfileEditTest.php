<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_プロフィール編集画面に過去の入力値が初期値として表示される()
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
        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
        $response->assertSee('123-4567');
        $response->assertSee('東京都港区');
        $response->assertSee('テストビル101');
        $response->assertSee($profilePath);
    }

}
