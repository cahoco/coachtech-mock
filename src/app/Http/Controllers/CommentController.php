<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id,
            'content' => $request->input('content'),
        ]);
        return redirect()->route('items.show', ['item_id' => $item_id]);
    }

}
