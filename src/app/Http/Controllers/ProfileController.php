<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function mypage()
    {
        $user = Auth::user(); // ログイン中のユーザーを取得
        return view('users.mypage', compact('user'));
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

        // プロフィールの更新 or 作成
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nickname' => $validated['name'],
                'zipcode' => $validated['zipcode'],
                'address' => $validated['address'],
                'building' => $validated['building'],
                // 'profile_image' => $path（画像アップロード処理を行う場合）
            ]
        );

        return redirect()->route('items.index')->with('success', 'プロフィールを更新しました');
    }
}
