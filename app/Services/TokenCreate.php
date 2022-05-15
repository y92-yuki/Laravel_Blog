<?php
namespace App\Services;

use Illuminate\Support\Str;

class TokenCreate {
    protected $token;

    public function __construct($num, $message) {
        $this->token = md5(Str::random($num) . $message);
    }

    public function getToken() {
        return $this->token;
    }
}