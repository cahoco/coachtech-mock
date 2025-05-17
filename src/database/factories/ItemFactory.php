<?php

// ItemFactory.php の修正例

namespace Database\Factories;

use App\Models\Item;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                '腕時計', 'HDD', '玉ねぎ3束', '革靴', 'ノートPC',
                'マイク', 'ショルダーバッグ', 'タンブラー', 'コーヒーミル', 'メイクセット'
            ]),
            'price' => $this->faker->randomElement([15000, 5000, 300, 4000, 45000, 8000, 3500, 500, 4000, 2500]),
            'description' => $this->faker->randomElement([
                'スタイリッシュなデザインのメンズ腕時計',
                '高速で信頼性の高いハードディスク',
                '新鮮な玉ねぎ3束のセット',
                'クラシックなデザインの革靴',
                '高性能なノートパソコン',
                '高音質のレコーディング用マイク',
                'おしゃれなショルダーバッグ',
                '使いやすいタンブラー',
                '手動のコーヒーミル',
                '便利なメイクアップセット',
            ]),
            'image' => 'images/' . $this->faker->randomElement([
                'watch.jpg',
                'hdd.jpg',
                'onion.jpg',
                'shoes.jpg',
                'laptop.jpg',
                'mic.jpg',
                'bag.jpg',
                'tumbler.jpg',
                'mill.jpg',
                'makeup.jpg',
            ]),
            'condition_id' => Condition::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
