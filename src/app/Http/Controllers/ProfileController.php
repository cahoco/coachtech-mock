<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function mypage()
    {
        $user = auth()->user()->load('profile');
        $items = $user->items()->get(); // 出品した商品

        return view('users.mypage', compact('user', 'items'));
    }

    public function edit()
    {
        $user = auth()->user()->load('profile');
        return view('users.edit', compact('user'));
    }

    public function update(AddressRequest $request)
    {
        $user = Auth::user();

        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 画像アップロード処理
        if ($request->hasFile('profile_image')) {
            // storage/app/public/images に保存 → storage/images/ファイル名 で公開可能
            $filename = $request->file('profile_image')->store('images', 'public');
            $validated['profile_image'] = 'storage/' . $filename;
        }

        // プロフィールの更新 or 作成
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nickname' => $validated['name'],
                'zipcode' => $validated['zipcode'],
                'address' => $validated['address'],
                'building' => $validated['building'],
                'profile_image' => $validated['profile_image'] ?? $user->profile->profile_image ?? null,
            ]
        );

        return redirect()->route('items.index')->with('success', 'プロフィールを更新しました');
    }

}
