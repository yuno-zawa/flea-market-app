<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'brand',
        'condition',
    ];

    // リレーション：商品は複数の画像を持つ
    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }

    // リレーション：商品は1人のユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // リレーション：商品は1つの購入情報を持つ
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    // 購入済みかどうか判定
    public function isSold()
    {
        return $this->purchase !== null;
    }

    // カテゴリのリレーション
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
    }

// コメントのリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

// いいねのリレーション
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

// いいね数を取得
    public function likesCount()
    {
        return $this->likes()->count();
    }

// ログインユーザーがいいねしているか
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}