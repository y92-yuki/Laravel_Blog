<?php

namespace App;

use App\Mail\SendEmailReset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ChangeEmail;
use Carbon\Carbon;
use Mail;

class EmailReset extends Model
{

    protected $table = 'email_reset';

    protected $fillable = [
        'user_id',
        'new_email',
        'token'
    ];

    public function checkExpired($created_at) {
        $expired = new Carbon($created_at);
        return $expired->addHour(1)->isPast();
    }
}
