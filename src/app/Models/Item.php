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
}
