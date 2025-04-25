<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Condition;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        // ✅ ダミーユーザーの作成（マイページに表示されないように、test@example.comではなくdummy@example.comなどで作成）
        $dummyUser = User::factory()->create([
            'name' => 'ダミー出品者',
            'email' => 'dummy@example.com',
            'password' => bcrypt('dummy1234'),
        ]);

        $dummyUser->profile()->create([
            'nickname' => 'ダミー太郎',
            'profile_image' => 'storage/images/dummy.jpg',
            'zipcode' => '000-0000',
            'address' => '東京都ダミー市',
            'building' => 'ダミービル101',
        ]);

        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image' => 'watch.jpg',
                'condition' => '良好',
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'image' => 'hdd.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image' => 'onion.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image' => 'shoes.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image' => 'laptop.jpg',
                'condition' => '良好',
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image' => 'mic.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'image' => 'bag.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'image' => 'tumbler.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image' => 'mill.jpg',
                'condition' => '良好',
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image' => 'makeup.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
        ];

        foreach ($items as $item) {
            $condition = Condition::where('name', $item['condition'])->first();
            if (!$condition) continue;
            Item::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'description' => $item['description'],
                'image' => 'storage/images/' . $item['image'],
                'condition_id' => $condition->id,
                'user_id' => $dummyUser->id,
            ]);
        }
    }
}
