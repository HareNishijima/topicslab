<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicLike extends Model
{

    use HasFactory;

    public function topics()
    {
        return $this->belongsTo(Topic::class);//いいねの数はトピックが持つ情報(逆の関係)
    }

    public function user()
    {
        return $this->hasMany(User::class);//トピックのいいねに対してユーザは複数(user_id)
    }

}
