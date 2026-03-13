@extends('layouts.app')

@section('title', '商品の出品')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h1>商品の出品</h1>

    <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="form-group">
            <label for="image">商品画像</label>
            <div class="image-upload-area">
                <img id="preview" src="" alt="" style="display: none; max-width: 100%; margin-bottom: 10px;">
                <label for="image" class="image-upload-btn">画像を選択する</label>
                <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
            </div>
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <h2>商品の詳細</h2>

        <div class="form-group">
            <label>カテゴリー</label>
            <div class="checkbox-group">
                @foreach($categories as $category)
                    <label class="checkbox-label">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                            style="display: none;"
                        >
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            @error('categories')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition">商品の状態</label>
            <select id="condition" name="condition">
                <option value="">選択してください</option>
                <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('condition')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <h2>商品名と説明</h2>

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="brand">ブランド名</label>
            <input type="text" id="brand" name="brand" value="{{ old('brand') }}" placeholder="任意">
            @error('brand')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">商品の説明</label>
            <textarea id="description" name="description" rows="5">{{ old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">販売価格</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" placeholder="¥">
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">出品する</button>
    </form>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');

            if (file && preview) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection