<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // 複数代入を許可するカラム（保存時に使う）
    protected $fillable = [
        'name',
        'description',
        'price',
        'condition_id',
        'image_path',
        'user_id',
    ];

    /**
     * 条件（condition）とのリレーション（1対多の「多」側）
     */
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    /**
     * ユーザーとのリレーション（出品者）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * カテゴリとのリレーション（多対多）
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
