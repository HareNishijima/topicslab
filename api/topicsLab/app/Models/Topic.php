<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);//1つのトピックに対してユーザが1つ
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);//1つのトピックに対してコメントが複数
    }

    public static function scopeSimpleAllList($query)
    {
        return $query->select(['id', 'title', 'created_at']);
    }
}
