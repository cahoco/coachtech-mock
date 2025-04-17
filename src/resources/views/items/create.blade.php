@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-container">
    <h2 class="profile-edit-title">商品の出品</h2>

    <form action="#" method="POST" enctype="multipart/form-data" class="form">
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
        </div>


        <!-- 商品の詳細 -->
        <h3 class="section-title">商品の詳細</h3>

        <!-- カテゴリー -->
        <div class="form-group">
            <label class="form-label">カテゴリー</label>
            <div class="category-list">
                @foreach (['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'] as $category)
                    <label class="category-chip">
                        <input type="checkbox" name="categories[]" value="{{ $category }}">
                        <span>{{ $category }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 商品の状態 -->
        <div class="form-group">
            <label class="form-label">商品の状態</label>
            <select name="condition" class="form-select">
                <option value="">選択してください</option>
                <option value="新品">新品</option>
                <option value="未使用に近い">未使用に近い</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
            </select>
        </div>

        <!-- 商品名と説明 -->
        <h3 class="section-title">商品名と説明</h3>

        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label">ブランド名</label>
            <input type="text" name="brand" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label">商品の説明</label>
            <textarea name="description" class="form-textarea"></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">販売価格</label>
            <input type="number" name="price" class="form-input" placeholder="¥">
        </div>

        <div class="form-submit">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection
