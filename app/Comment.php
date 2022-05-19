<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Services\Subtitle;

class Comment extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['is_like_by_login_user'];


    //ユーザーがしたコメント一覧をマイページに表示
    public function getCommentPostuserAttribute() {
        //マイページの「コメントした投稿一覧」に表示するデータ
        $comments = [$this->post['title'],$this->post->user['name'],$this['message']];
        
        //文字数省略表示のための加工
        $modifiedComments = Subtitle::getSubtitles($comments,10);
        //viewでの中身を明示するためにキーを振る
        $modifiedComments = [
            'title' => $modifiedComments[0],
            'postUserName' => $modifiedComments[1],
            'message' => $modifiedComments[2]
        ];

        return $modifiedComments;
    }

    //投稿にいいね済みか判定
    public function getIsLikeByLoginUserAttribute() {
        return $this->likes()->where('user_id',Auth::id())->exists();
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function post() {
        return $this->belongsTo('App\Post');
    }

    //コメントへのいいね用中間テーブル
    public function likes() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }


}
