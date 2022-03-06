<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use SoftDeletes;


    protected $guarded = ['id'];

    public function existsLike() {
        return $this->likes()->where('user_id',Auth::id())->exists();
    }
    

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function post() {
        return $this->belongsTo('App\Post');
    }

    public function likes() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }


}
