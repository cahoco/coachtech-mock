<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;

class ProfileController extends Controller
{
    public function mypage(Request $request)
    {
        $user = auth()->user()->load('profile');
        $tab = $request->query('tab', 'sell'); // ← クエリパラメータからtabを取得

        // 出品商品（常に取得）
        $soldItems = $user->items;

        // 購入商品（Order経由でItem取得）
        $purchasedItems = $user->orders()->with('item')->get()->pluck('item');

        return view('users.mypage', compact('user', 'tab', 'soldItems', 'purchasedItems'));
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

    // 住所変更画面の表示
    public function editAddress($item_id)
    {
        $user = Auth::user()->load('profile');
        $item = \App\Models\Item::findOrFail($item_id);
        return view('orders.address', compact('user', 'item'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        $user = Auth::user();

        $validated = $request->validated();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('orders.confirm', ['item_id' => $item_id])
                        ->with('success', '住所を更新しました');
    }

}
