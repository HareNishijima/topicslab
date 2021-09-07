<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->belongsTo(Comment::class);//いいねの数はコメントが持つ情報(逆の関係)
    }

    public function user()
    {
        return $this->hasMany(User::class);//コメントのいいねに対してユーザは複数(user_id)
    }
}
