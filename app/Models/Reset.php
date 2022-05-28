<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reset extends Model
{
    protected $fillable = [
        'user_id',
        'new_value',
        'token',
        'expired_at'
    ];
}
