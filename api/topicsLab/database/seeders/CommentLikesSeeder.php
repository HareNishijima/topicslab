<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CommentLikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment_likes')->insert([
            'user_id' => '1',
            'comment_id' => '1',
        ]);
        DB::table('comment_likes')->insert([
            'user_id' => '2',
            'comment_id' => '1',
        ]);
        DB::table('comment_likes')->insert([
            'user_id' => '2',
            'comment_id' => '2',
        ]);
    }
}
