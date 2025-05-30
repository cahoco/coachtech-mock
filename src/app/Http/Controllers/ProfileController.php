<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function mypage(Request $request)
    {
        $user = auth()->user()->load('profile');
        $tab = $request->query('tab', 'sell');
        $soldItems = $user->items;
        $purchasedItems = $user->orders()->with('item.order')->get()->pluck('item');
        return view('users.mypage', compact('user', 'tab', 'soldItems', 'purchasedItems'));
    }

    public function edit()
    {
        $user = auth()->user()->load('profile');
        return view('users.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        if ($request->hasFile('profile_image')) {
            $filename = $request->file('profile_image')->store('images', 'public');
            $validated['profile_image'] = 'storage/' . $filename;
        }
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nickname' => $validated['nickname'],
                'zipcode' => $validated['zipcode'],
                'address' => $validated['address'],
                'building' => $validated['building'],
                'profile_image' => $validated['profile_image'] ?? $user->profile->profile_image ?? null,
            ]
        );
        return redirect()->route('items.index')->with('success', 'プロフィールを更新しました');
    }

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
        return redirect()->route('orders.confirm', [
            'item_id' => $item_id,
            'payment_method' => $request->payment_method,
        ])
                        ->with('success', '住所を更新しました');
    }

}
