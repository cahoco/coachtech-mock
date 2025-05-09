<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログアウトができる()
    {
        // ユーザーを作成してログイン状態にする
        $user = User::factory()->create();
        $response = $this->actingAs($user);

        // POSTでログアウト処理を実行（通常はPOST /logout）
        $response = $this->post('/logout');

        // リダイレクトされることを確認（通常はログインページなど）
        $response->assertRedirect('/');

        // 認証されていないことを確認
        $this->assertGuest();
    }
}
