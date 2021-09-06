<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);//トピックはユーザが持つ情報(逆の関係)
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);//トピックは複数のコメントを持つ
    }

    public function like()//いいねの数
    {
        return $this->hasMany(TopicLike::class);//トピックに対していいねをしたuser_idが複数
    }

    public static function scopeSimpleAllList($query)
    {
        return $query->select(['id', 'title', 'created_at']);
    }
}
