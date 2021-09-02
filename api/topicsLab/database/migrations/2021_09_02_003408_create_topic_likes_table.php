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
            $table->integer('good');//いいねの数
            $table->foreignId('topic_id')->constrained('topics');
            $table->foreignId('user_id')->constrained('users');            
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
