@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="tab-container">
    <div class="tab-menu">
        <a href="#" class="tab active">おすすめ</a>
        <a href="#" class="tab">マイリスト</a>
    </div>
</div>

<div class="item-list">
    @foreach ($items as $item)
        <div class="item-card">
            <a href="{{ route('items.show', ['item_id' => $item->id]) }}">
                <img src="{{ asset('storage/' . $item->image) }}" class="item-image" alt="商品画像">
            </a>
            <div class="item-name">{{ $item->name }}</div>
        </div>
    @endforeach
</div>

@endsection
