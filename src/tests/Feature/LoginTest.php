<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/login';

    public function test_メールアドレスが未入力だとバリデーションエラーになる()
    {
        $response = $this->post($this->url, [
            'email' => '',
            'password' => 'password123',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_パスワードが未入力だとバリデーションエラーになる()
    {
        $response = $this->post($this->url, [
            'email' => 'test@example.com',
            'password' => '',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    public function test_入力情報が誤っているとログインに失敗しエラーメッセージが表示される()
    {
        $response = $this->from('/login')->post($this->url, [
            'email' => 'wrong@example.com',
            'password' => 'invalidpassword',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_正しい情報でログインするとホームにリダイレクトされる()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
        $response = $this->post($this->url, [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

}
