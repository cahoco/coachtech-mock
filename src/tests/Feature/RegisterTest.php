<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private $url = '/register';

    public function test_名前が未入力だとバリデーションエラーになる()
    {
        $response = $this->post($this->url, [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_メールアドレスが未入力だとバリデーションエラーになる()
    {
        $response = $this->post($this->url, [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_パスワードが未入力だとバリデーションエラーになる()
    {
        $response = $this->post($this->url, [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    public function test_パスワードが7文字以下だとバリデーションエラーになる()
    {
        $response = $this->post($this->url, [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    public function test_パスワードと確認用が一致しないとバリデーションエラーになる()
    {
        $response = $this->post($this->url, [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    public function test_入力が全て正しい場合はユーザー登録されログイン画面にリダイレクトされる()
    {
        $response = $this->post($this->url, [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertRedirect('/email/verify');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

}
