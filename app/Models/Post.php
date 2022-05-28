<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Services\Subtitle;

class Post extends Model
{
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $guarded = ['id'];
    protected $softCascade = ['comment'];

    public function getIndexPost() {
        //indexの投稿一覧に表示するデータ
        $id = $this->id;
        $title = $this->title;
        $message = $this->message;
        $userName = $this->user->name;

        //文字数省略表示のための加工
        $modifiedTitle = Subtitle::getSubtitles($title,10);
        $modifiedMessage = Subtitle::getSubtitles($message,20);

        //viewでの中身を明示するためにキーを振る
        $modifiedPosts = [
            'id' => $id,
            'title' => $modifiedTitle,
            'message' => $modifiedMessage,
            'user_name' => $userName
        ];

        return $modifiedPosts;
    }

    //ユーザーの投稿一覧
    public function getIdTitle() {
        //マイページの投稿一覧に表示するデータ
        $id = $this->id;
        $title = $this->title;

        //文字数省略表示のための加工
        $modifiedTitle = Subtitle::getSubtitles($title,10);

        //viewでの中身を明示するためにキーを振る
        $modifiedPosts = [
            'id' => $id,
            'title' => $modifiedTitle
        ];

        return $modifiedPosts;
    }

    public function postExistsLike() {
        return $this->users()->where('user_id',Auth::id())->exists();
    }

    public function user() {
        return $this->BelongsTo('App\Models\User');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    public function users() {
        return $this->belongsToMany('App\Models\user')->withTimestamps();
    }

    public function images() {
        return $this->hasMany('App\Models\Image');
    }

}
