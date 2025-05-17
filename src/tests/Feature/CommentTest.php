<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post("/comment/{$item->id}", [
            'content' => 'とても良い商品ですね！',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'とても良い商品ですね！',
        ]);
    }

    public function test_未ログインユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();
        $response = $this->post("/comment/{$item->id}", [
            'content' => '未ログインでコメント送信',
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'content' => '未ログインでコメント送信',
        ]);
    }

    public function test_コメントが空だとバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $response = $this->actingAs($user)->post("/comment/{$item->id}", [
            'content' => '',
        ]);
        $response->assertSessionHasErrors(['content']);
    }

    public function test_コメントが255文字を超えるとバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $longComment = str_repeat('あ', 256);
        $response = $this->actingAs($user)->post("/comment/{$item->id}", [
            'content' => $longComment,
        ]);
        $response->assertSessionHasErrors(['content']);
    }

}
