@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h1>プロフィール設定</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group image-upload">
            <div class="image-preview">
                @if(Auth::user()->profile_image)
                    <img id="preview" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール画像">
                @else
                    <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="プロフィール画像" style="display: block;">
                @endif
            </div>

            <label for="image" class="upload-button">画像を選択する</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" style="display: none;">

            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">
            @error('postal_code')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', Auth::user()->building) }}">
            @error('building')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection