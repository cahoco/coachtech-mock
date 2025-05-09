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
            if (Auth::check()) {
                // クエリビルダでフィルタ可能なように最初に join を使う
                $query = Auth::user()->likedItems()
                    ->where('items.user_id', '!=', Auth::id())
                    ->with(['likedUsers', 'comments', 'order']);

                if ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                }

                $items = $query->get();
            } else {
                $items = collect();
            }
        } else {
            // ダミーユーザーの表示（例：nameにダミーが含まれる）
            $query = Item::whereHas('user', function ($q) {
                $q->where('name', 'like', '%ダミー%');
            })->with(['likedUsers', 'comments', 'order']);

            if ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }

            $items = $query->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('items.create', compact('categories', 'conditions'));
    }

    // app/Http/Controllers/ItemController.php

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        // 画像保存...
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $item = Item::create(array_merge($validated, [
            'user_id' => Auth::id(),
            // brand は nullable なので $validated['brand'] がそのまま入る
        ]));

        // sync する ID の取り出し
        if ($request->filled('categories')) {
            $item->categories()->sync($request->input('categories'));
        } else {
            $item->categories()->sync([ $request->input('category_id') ]);
        }

        return redirect('/')->with('success', '商品を出品しました');
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