<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TopiclikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topic_likes')->insert([
            'topic_id' => '1',
            'user_id' => '1',
        ]);
        DB::table('topic_likes')->insert([
            'topic_id' => '1',
            'user_id' => '2',
        ]);
        DB::table('topic_likes')->insert([
            'topic_id' => '2',
            'user_id' => '2',
        ]);
    }
}
