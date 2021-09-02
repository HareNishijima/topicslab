<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicLike extends Model
{

    use HasFactory;

    public function topics()
    {
        return $this->belongsTo(Topic::class);//1つのトピックのいいねに対してトピックが1つ
    }

    public function user()
    {
        return $this->hasMany(User::class);//1つのトピックのいいねに対してユーザが複数
    }

}
