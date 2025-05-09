<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // テストユーザーを生成
            'item_id' => Item::factory(), // テストアイテムを生成
            'content' => $this->faker->text(255), // ランダムなテキストを生成
        ];
    }
}
