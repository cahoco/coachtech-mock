<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Item;
use App\Models\Profile;
use App\Http\Requests\PurchaseRequest;

class OrderController extends Controller
{
    public function confirm($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $address = $user->profile; // 住所情報は profile に保存されている想定

        return view('orders.confirm', compact('item', 'address'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;

        if ($item->order) {
            return back()->withErrors(['message' => 'すでに購入されています']);
        }

        Order::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'zipcode' => $profile->zipcode,
            'address' => $profile->address,
            'building' => $profile->building,
        ]);

        return redirect()->route('mypage')->with('success', '購入が完了しました');
    }

}
