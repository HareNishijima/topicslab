<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    public function comment()
    {
        return $this->belongsTo(Comment::class);//いいねの数はコメントが持つ情報(逆の関係)
    }

    public function user()
    {
        return $this->belongsTo(User::class);//いいねの数はユーザが複数持つ情報(逆の関係)
    }
}
