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
        'name', 'email', 'pref_id', 'password',
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

    //都道府県リスト
    public static $prefs = [
        1 => '北海道', 2 => '青森県', 3 => '岩手県', 4 => '宮城県', 5 => '秋田県', 6 => '山形県', 7 => '福島県', 8 => '茨城県', 9 => '栃木県',
        10 => '群馬県', 11 => '埼玉県', 12 => '千葉県', 13 => '東京都', 14 => '神奈川県', 15 => '新潟県', 16 => '富山県', 17 => '石川県',
        18 => '福井県', 19 => '山梨県', 20 => '長野県', 21 => '岐阜県', 22 => '静岡県', 23 => '愛知県', 24 => '三重県', 25 => '滋賀県',
        26 => '京都府', 27 => '大阪府', 28 => '兵庫県', 29 => '奈良県', 30 => '和歌山県', 31 => '鳥取県', 32 => '島根県',33 => '岡山県',
        34 => '広島県', 35 => '山口県', 36 => '徳島県', 37 => '香川県', 38 => '愛媛県', 39 => '高知県', 40 => '福岡県', 41 => '佐賀県',
        42 => '長崎県', 43 => '熊本県', 44 => '大分県', 45 => '宮崎県', 46 => '鹿児島県', 47 => '沖縄県'
    ];

    //県庁所在地リスト
    public static $prefOfficeLocation = [
        1 => 'Sapporo', 2 => 'Aomori', 3 => 'Morioka', 4 => 'Sendai', 5 => 'Akita', 6 => 'Yamagata', 7 => 'Fukushima', 8 => 'Mito',
        9 => 'Utsunomiya', 10 => 'Maebashi', 11 => 'Saitama', 12 => 'Chiba', 13 => 'Shinjuku', 14 => 'Yokohama', 15 => 'Niigata',
        16 => 'Toyama', 17 => 'Kanazawa', 18 => 'Fukui', 19 => 'Kofu', 20 => 'Nagano', 21 => 'Gifu', 22 => 'Shizuoka', 23 => 'Nagoya',
        24 => 'Tsu', 25 => 'Otsu', 26 => 'Kyoto', 27 => 'Osaka', 28 => 'Kobe', 29 => 'Nara', 30 => 'Wakayama', 31 => 'Tottori', 32 => 'Matsue',
        33 => 'Okayama', 34 => 'Hiroshima', 35 => 'Yamaguchi', 36 => 'Tokushima', 37 => 'Takamatsu', 38 => 'Matsuyama', 39 => 'kochi',
        40 => 'Fukuoka', 41 => 'Saga', 42 => 'Nagasaki', 43 => 'Kumamoto', 44 => 'Oita', 45 => 'Miyazaki', 46 => 'Kagoshima', 47 => 'Naha'
    ];

    
    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function comment() {
        return $this->hasMany('App\Comment');
    }

    public function comments() {
        return $this->belongsToMany('App\Comment')->withTimestamps();
    }

    public function postLikes() {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }

    public function pref() {
        return $this->belongsTo('App\Pref');
    }
}
