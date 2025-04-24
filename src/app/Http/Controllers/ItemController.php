<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend'); // デフォルトはおすすめ

        if ($tab === 'mylist') {
            // 👍 ユーザーがいいねした商品を取得
            $items = Auth::user()->likedItems()->with(['likedUsers', 'comments'])->get();
        } else {
            // 👍 ダミーユーザーのおすすめ商品
            $dummyUser = \App\Models\User::where('email', 'dummy@example.com')->first();
            $items = $dummyUser ? Item::where('user_id', $dummyUser->id)->with(['likedUsers', 'comments'])->get() : collect();
        }

        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        // 画像保存（storage/app/public/images → public/storage/images にリンクされている）
        $path = $request->file('image')->store('images', 'public');

        // 商品作成
        $item = Item::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => 'storage/' . $path,
            'condition_id' => $validated['condition_id'],
            'user_id' => Auth::id(),
        ]);

        // カテゴリーの登録（中間テーブル）
        $item->categories()->sync($request->input('categories'));

        return redirect()->route('items.index')->with('success', '商品を出品しました');
    }

    public function show($item_id)
    {
        $item = Item::with(['likedUsers', 'comments.user.profile'])
            ->withCount('comments')
            ->findOrFail($item_id);

        return view('items.show', compact('item'));
    }

    public function toggleLike(Item $item)
    {
        $user = Auth::user();

        if ($user->likes->contains($item->id)) {
            $user->likes()->detach($item->id);
        } else {
            $user->likes()->attach($item->id);
        }

        return back();
    }
}
