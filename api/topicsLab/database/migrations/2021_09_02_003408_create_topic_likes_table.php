<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //トピックのいいねの数を保存するテーブル
        Schema::create('topic_likes', function (Blueprint $table) {
            //$table->integer('good');
            $table->id();
            $table->timestamps();
            $table->foreignId('topic_id')->constrained('topics');//トピックのid
            $table->foreignId('user_id')->constrained('users');//いいねをした人のユーザid
            /*topic_idとuser_idは1対1の関係にある
            いいねが増えるとtopic_likesのテーブルが増える
            withCount()で同じtopic_idを持つテーブル数を取得→いいねの数になる
            またtopic_likesとuser_idの2つが同じテーブルは存在しない(二重にいいねしたことになる)
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_likes');
    }
}
