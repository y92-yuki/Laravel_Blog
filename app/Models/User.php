<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'prefecture_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    //投稿の情報
    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    //投稿に対するコメントの情報
    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    //コメントに対するいいね用中間テーブル
    public function commentLikes() {
        return $this->belongsToMany('App\Models\Comment')->withTimestamps();
    }

    //投稿に対するいいね用中間テーブル
    public function postLikes() {
        return $this->belongsToMany('App\Models\Post')->withTimestamps();
    }

    //ユーザーの登録地域情報
    public function prefInfo() {
        return $this->belongsTo('App\Models\Prefecture','prefecture_id');
    }

}
