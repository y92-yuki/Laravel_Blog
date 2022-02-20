<?php

use Illuminate\Database\Seeder;
use App\Post;

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
        ];
        $post = new Post;
        $post->fill($param)->save();

        $param = [
            'user_id' => 2,
            'title' => 'テスト2',
            'message' => 'Seederで作成したテストデータ2'
        ];
        $post = new Post;
        $post->fill($param)->save();

        $param = [
            'user_id' => 3,
            'title' => 'テスト3',
            'message' => 'Seederで作成したテストデータ3'
        ];
        $post = new Post;
        $post->fill($param)->save();
        
    }
}
