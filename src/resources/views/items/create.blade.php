@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-container">
    <h2 class="page-title">商品の出品</h2>

    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <div class="form-group">
            <label class="form-label">商品画像</label>
            <div class="image-upload-box">
                <label class="image-button">
                    画像を選択する
                    <input type="file" name="image" id="image" style="display: none;">
                </label>
            </div>
            @error('image')<div class="error-message">{{ $message }}</div>@enderror
        </div>


        <!-- 商品の詳細 -->
        <h3 class="section-title">商品の詳細</h3>

        <!-- カテゴリー -->
        <div class="form-group">
            <label class="form-label">カテゴリー</label>
            <div class="category-list">
            @foreach ($categories as $category)
                <label class="category-chip">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                </label>
            @endforeach
            @error('categories')<div class="error-message">{{ $message }}</div>@enderror
            </div>
        </div>

        <!-- 商品の状態 -->
        <div class="form-group">
            <label class="form-label">商品の状態</label>
                <select name="condition_id" class="form-select">
                    <option value="">選択してください</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
                @error('condition_id')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <!-- 商品名と説明 -->
        <h3 class="section-title">商品名と説明</h3>

        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" class="form-input">
            @error('name')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">ブランド名</label>
            <input type="text" name="brand" class="form-input">
            @error('brand')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">商品の説明</label>
            <textarea name="description" class="form-textarea"></textarea>
            @error('description')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">販売価格</label>
            <input type="number" name="price" class="form-input" placeholder="¥">
            @error('price')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-submit">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection
