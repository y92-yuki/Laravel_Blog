<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmailReset extends Model
{

    protected $table = 'email_reset';

    protected $fillable = [
        'user_id',
        'new_email',
        'token',
        'expired_at'
    ];
}
