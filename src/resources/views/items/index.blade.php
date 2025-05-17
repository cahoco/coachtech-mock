@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="tab-container">
    <div class="tab-menu">
        <a href="{{ route('items.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}" class="tab {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
        @auth
            <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}" class="tab {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
        @else
            <a href="{{ route('login') }}" class="tab">マイリスト</a>
        @endauth
    </div>
</div>
<div class="item-list">
    @foreach ($items as $item)
        <div class="item-card">
            <a href="{{ route('items.show', ['item_id' => $item->id]) }}">
                <div class="item-image-wrapper" style="position: relative;">
                    <img src="{{ asset($item->image) }}" class="item-image" alt="商品画像">
                    @if ($item->order)
                        <div class="sold-label">sold</div>
                    @endif
                </div>
            </a>
            <div class="item-name">{{ $item->name }}</div>
        </div>
    @endforeach
</div>
@endsection
