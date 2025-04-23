<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all(); // 商品一覧を表示したい場合
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    // ✅ 商品保存処理を追加
    public function store(Request $request)
    {

        // 画像保存処理（storage/app/public/images に保存される）
        $path = $request->file('image')->store('images', 'public');

        // 登録処理
        Item::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $path, // 画像パス
            'condition_id' => $validated['condition_id'],
            'user_id' => Auth::id(), // 出品者ID
        ]);

        return redirect()->route('items.index')->with('success', '商品を出品しました');
    }
}
