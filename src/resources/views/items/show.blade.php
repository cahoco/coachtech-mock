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
                {{-- いいね数・コメント数 --}}
                <div class="likes-comments">
                    <div class="icon-block">
                        <form method="POST" action="{{ route('items.toggleLike', $item->id) }}" class="like-form">
                            @csrf
                            <button type="submit" class="like-button">
                                <img src="{{ Auth::user()->likes->contains($item->id) ? asset('storage/images/liked.png') : asset('storage/images/like.png') }}" alt="いいね" class="icon">
                            </button>
                        </form>
                        <p class="count">{{ $item->likedUsers ? $item->likedUsers->count() : 0 }}</p>
                    </div>
                    <div class="icon-block">
                        <img src="{{ asset('storage/images/comments.png') }}" alt="コメントアイコン" class="icon">
                        <div class="count">{{ $item->comments_count ?? 0 }}</div>
                    </div>
                </div>
                <a href="#" class="buy-button">購入手続きへ</a>
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

                <div class="comment-section">
                    <h3 class="comment-title1">コメント ({{ $item->comments ? $item->comments->count() : 0 }})</h3>
                    @foreach($item->comments as $comment)
                    <div class="comment-box">
                        {{-- プロフィール画像と名前を横並びにする --}}
                        <div class="comment-header">
                            <img src="{{ asset($comment->user->profile->profile_image ?? 'storage/images/default.png') }}" alt="プロフィール画像">
                            <strong class="comment-username">{{ $comment->user->profile->nickname ?? 'ユーザー' }}</strong>
                        </div>
                        {{-- コメントは画像の下に左寄せで表示 --}}
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
                                    @error('content')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
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
