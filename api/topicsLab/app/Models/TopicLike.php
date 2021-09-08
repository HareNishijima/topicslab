<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicLike extends Model
{

    use HasFactory;

    //1トピックに対していいねをした人は1人

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        //return $this->belongsToMany(User::class);
        return $this->belongsTo(User::class);
    }
}
