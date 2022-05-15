<?php

namespace App;

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
    
    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function commentLikes() {
        return $this->belongsToMany('App\Comment')->withTimestamps();
    }

    public function postLikes() {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }

    public function prefInfo() {
        return $this->belongsTo('App\Prefecture','prefecture_id');
    }

}
