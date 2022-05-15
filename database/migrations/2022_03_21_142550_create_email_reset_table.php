<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailResetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_reset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('メールアドレスを更新するユーザーのID');
            $table->string('new_email')->comment('ユーザーが新規に設定したメールアドレス');
            $table->string('token');
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_reset');
    }
}
