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
            $query = Item::where('user_id', '!=', Auth::id())
                ->with(['likedUsers', 'comments', 'order']);
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

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = 'storage/' . $path;
        }
        $item = Item::create(array_merge($validated, [
            'user_id' => Auth::id(),
        ]));
        if ($request->filled('categories')) {
            $item->categories()->sync($request->input('categories'));
        } else {
            $item->categories()->sync([ $request->input('category_id') ]);
        }
        return redirect('/')->with('success', '商品を出品しました');
    }

    public function show($item_id)
    {
        $item = Item::with(['likedUsers', 'comments.user.profile',])
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
        $user->profile()->updateOrCreate([], $validated);
        return redirect()->route('orders.confirm', ['item_id' => $item_id])
                        ->with('success', '住所を更新しました');
    }

}