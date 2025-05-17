@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="show-container">
    <div class="product-main">
        <div class="product-image">
            <img src="{{ asset($item->image) }}" alt="商品画像">
        </div>
        <div class="product-detail">
            <h2 class="product-title">{{ $item->name }}</h2>
                <p class="product-brand">{{ $item->brand ?? 'ブランド名' }}</p>
                <p class="product-price">¥{{ number_format($item->price) }} <span>（税込）</span></p>
                    <div class="product-actions">
                        <div class="likes-comments">
                            <div class="icon-block">
                                <form method="POST" action="{{ route('items.toggleLike', $item->id) }}" class="like-form">
                                    @csrf
                                    <button type="submit"
                                        class="like-button {{ Auth::check() && Auth::user()->likes->contains($item->id) ? 'liked-icon' : '' }}">
                                        @if (Auth::check() && Auth::user()->likes->contains($item->id))
                                            <img src="{{ asset('storage/images/liked.png') }}" alt="いいね" class="icon">
                                        @else
                                            <img src="{{ asset('storage/images/like.png') }}" alt="いいね" class="icon">
                                        @endif
                                    </button>
                                </form>
                                <p class="count">{{ $item->likedUsers ? $item->likedUsers->count() : 0 }}</p>
                            </div>
                            <div class="icon-block">
                                <img src="{{ asset('storage/images/comments.png') }}" alt="コメントアイコン" class="icon">
                                <div class="count">{{ $item->comments_count ?? 0 }}</div>
                            </div>
                        </div>
                        @unless (Auth::id() === $item->user_id)
                            <a href="{{ route('orders.confirm', ['item_id' => $item->id]) }}" class="buy-button">購入手続きへ</a>
                        @endunless
                    </div>
                    <h3 class="section-title">商品説明</h3>
                        <p class="product-description">{!! nl2br(e($item->description)) !!}</p>
                    <h3 class="section-title">商品の情報</h3>
                        <div class="product-meta">
                            <div class="categories">
                                <span>カテゴリー</span>
                                @foreach($item->categories as $category)
                                    <span class="category-tag">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <div class="condition">
                                <span>商品の状態</span>
                                <span>{{ $item->condition->name }}</span>
                            </div>
                        </div>
                    <div class="comment-section">
                        <h3 class="comment-title1">コメント ({{ $item->comments ? $item->comments->count() : 0 }})</h3>
                            @foreach($item->comments as $comment)
                            <div class="comment-box">
                                <div class="comment-header">
                                    <img src="{{ optional($comment->user->profile)->profile_image? asset($comment->user->profile->profile_image): asset('storage/images/default.png') }}">
                                    <strong class="comment-username">{{ $comment->user->name }}</strong>
                                </div>
                                <div class="comment-content">
                                    {{ $comment->content }}
                                </div>
                            </div>
                            @endforeach
                                <h3 class="comment-title2">商品へのコメント</h3>
                                    <form action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="POST" class="comment-form">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <div class="form-group">
                                                <textarea name="content" class="form-textarea" rows="3" placeholder="コメントを入力してください"></textarea>
                                                @error('content')<div class="error-message">{{ $message }}</div>@enderror
                                            </div>
                                        <div class="form-submit">
                                            <button type="submit" class="submit-button">コメントを送信する</button>
                                        </div>
                                    </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
