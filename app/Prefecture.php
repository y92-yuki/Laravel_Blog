<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    protected $guarded = ['id'];

    public static function getPrefs() {
        return Prefecture::all();
    }

    public function prefUsers() {
        return $this->hasMany('App\User','prefecture_id');
    }
}
