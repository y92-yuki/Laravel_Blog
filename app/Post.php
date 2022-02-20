<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $guarded = ['id'];

    public function getData() {
        return $this->id . ':' . $this->title . '(' . $this->user->name . ')';
    }

    public function user() {
        return $this->BelongsTo('App\User');
    }

    public function comment() {
        return $this->hasMany('App\Comment');
    }
}
