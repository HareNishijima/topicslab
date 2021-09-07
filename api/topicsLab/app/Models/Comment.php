<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);//コメントはユーザが持つ情報(逆の関係)
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);//コメントはトピックが持つ情報(逆の関係)
    }

    public function like()//いいねの数
    {
        return $this->hasMany(CommentLike::class);//コメントに対していいねをしたuser_idが複数
    }

}
