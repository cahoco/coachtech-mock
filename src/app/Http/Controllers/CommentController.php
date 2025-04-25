<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $validated = $request->validated();

        // 保存処理
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $validated['item_id'],
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'コメントを投稿しました');
    }
}
