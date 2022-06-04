<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'ゲストユーザー',
            'email' => 'example@ne.jp',
            'prefecture_id' => 25,
            'email_verified_at' => new DateTime(),
            'password' => Hash::make(config('auth.guest_user_password')),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ];

        DB::table('users')->insert($param);
    }
}
