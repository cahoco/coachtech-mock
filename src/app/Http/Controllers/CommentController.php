<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'content' => ['required', 'string', 'max:255'],
        ]);

        Comment::create([
            'item_id' => $request->input('item_id'),
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました');
    }
}
