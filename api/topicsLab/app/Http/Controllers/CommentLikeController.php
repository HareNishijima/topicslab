<?php

namespace App\Http\Controllers;

use App\Models\CommentLike;
use App\Models\Comment;//追加
use App\Models\User;//追加
use Illuminate\Http\Request;

//class TopiclikeController extends Controller 長い間悩まされてきた
class CommentLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commentlike = new CommentLike;

        //$topiclike->topic_id = $request->topic_id;
        //$topiclike->user_id = $request->user_id;

        $comment = Comment::find($request->comment_id);//topic_idと一致するtopicのテーブルを取得
        $commentlike->comment()->associate($comment);//topiclike->belongsTo(Topic::class)

        $user = User::find($request->user_id);//user_idと一致するuserのテーブルを取得
        $commentlike->user()->associate($user);//user->belongsToMany(User::class)
  
        $commentlike->save();

        return $commentlike;
    }
}
