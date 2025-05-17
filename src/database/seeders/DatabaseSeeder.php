<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesTableSeeder::class,
            ConditionsTableSeeder::class,
            ItemsTableSeeder::class,
        ]);

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('00000000'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $user->profile()->create([
            'profile_image' => 'storage/images/test.jpg',
            'nickname' => 'てすと',
            'zipcode' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
            'building' => 'テストビル101',
        ]);
    }

}
