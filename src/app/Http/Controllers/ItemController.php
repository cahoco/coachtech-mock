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
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            $items = Auth::user()->likedItems()->with(['likedUsers', 'comments', 'order']);
        } else {
            $items = Item::where('user_id', '!=', Auth::id()) // 👈 自分以外
                            ->with(['likedUsers', 'comments', 'order']);
        }
        // if ($tab === 'mylist') {
        //     $items = Auth::user()->likedItems()->with(['likedUsers', 'comments', 'order']);
        // } else {
        //     $dummyUser = \App\Models\User::where('email', 'dummy@example.com')->first();
        //     $items = Item::where('user_id', $dummyUser->id)->with(['likedUsers', 'comments', 'order']);
        // }

        // 🔍 キーワード検索を追加
        if ($keyword) {
            $items = $items->where('name', 'like', '%' . $keyword . '%');
        }

        $items = $items->get();
        return view('items.index', compact('items', 'tab', 'keyword'));
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
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        // 商品作成
        $item = Item::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => 'storage/' . $path,
            'condition_id' => $validated['condition_id'],
            'user_id' => Auth::id(),
            'brand' => $request->input('brand'),
        ]);

        // カテゴリーの登録（中間テーブル）
        $item->categories()->sync($request->input('categories'));

        return redirect()->route('mypage')->with('success', '商品を出品しました');
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

    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        // addressは個別変数ではなく、$userに含まれているのでcompactしない
        return view('orders.address', compact('item', 'user'));
    }

    public function update(Request $request, $item_id)
    {
        $validated = $request->validate([
            'zipcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // プロフィール情報に保存
        $user->profile()->updateOrCreate([], $validated);

        // ✅ 購入確認画面へリダイレクト
        return redirect()->route('orders.confirm', ['item_id' => $item_id])
                        ->with('success', '住所を更新しました');
    }

}