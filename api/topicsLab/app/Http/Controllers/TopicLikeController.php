<?php

namespace App\Http\Controllers;

use App\Models\TopicLike;
use App\Models\Topic;//追加
use App\Models\User;//追加
use Illuminate\Http\Request;

//class TopiclikeController extends Controller
class TopicLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $topiclike = new TopicLike;

        //$topiclike->topic_id = $request->topic_id;
        //$topiclike->user_id = $request->user_id;

        $topic = Topic::find($request->topic_id);//topic_idと一致するtopicのテーブルを取得
        $topiclike->topic()->associate($topic);//topiclike->belongsTo(Topic::class)
            
        $user = User::find($request->user_id);//user_idと一致するuserのテーブルを取得
        $topiclike->user()->associate($user);//topiclike->->belongsToMany(User::class);

        
        
        $topiclike->save();

        return $topiclike;
    }
}
