<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $guarded = ['id'];
    protected $softCascade = ['comment'];

    // https://readouble.com/laravel/8.x/ja/eloquent-mutators.html
    public function getIndexTitleAttribute() {
        return $this->id . '.' . Str::limit($this->title,10,'...') . '(' . $this->user->name . ')';
    }

    // public function getPostIndex() {
    // //     return $this->id . '.' . Str::limit($this->title,10,'...') . '(' . $this->user->name . ')';
    // // }

    public function postExistsLike() {
        return $this->users()->where('user_id',Auth::id())->exists();
    }

    public function getPostMessage() {
        return Str::limit($this->message,20,'...');
    }

    public function user() {
        return $this->BelongsTo('App\User');
    }

    public function comment() {
        return $this->hasMany('App\Comment');
    }

    public function users() {
        return $this->belongsToMany('App\user')->withTimestamps();
    }

    public function images() {
        return $this->hasMany('App\Image');
    }

    // public static function boot() {
    //     parent::boot();

    //     static::deleting(function ($post) {
    //         $post->comment()->delete();
    //     });
    // }
}
