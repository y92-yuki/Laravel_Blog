<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'title' => 'テスト1',
            'message' => 'Seederで作成したテストデータ1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ];
        DB::table('posts')->insert($param);

        $param = [
            'user_id' => 2,
            'title' => 'テスト2',
            'message' => 'Seederで作成したテストデータ2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ];
        DB::table('posts')->insert($param);

        $param = [
            'user_id' => 3,
            'title' => 'テスト3',
            'message' => 'Seederで作成したテストデータ3',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ];
        DB::table('posts')->insert($param);
        
    }
}
