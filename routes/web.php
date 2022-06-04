<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//トップページ
Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['prefix' => 'post', 'middleware' => ['verified']] ,function() {
    //投稿一覧画面
    Route::get('','PostController@index')->name('post');

    //新規投稿画面
    Route::get('/create','PostController@create')->name('post.create');
    Route::post('/create','PostController@store');

    //投稿詳細画面
    Route::get('/show/{post_id}','PostController@show')->name('post.show');

    //コメント投稿
    Route::post('/show','CommentController@addComment');

    //コメントを取得
    Route::get('/show/getcomment/{post_id}','CommentController@getComment');

    //投稿編集画面
    Route::get('/edit/{post}','PostController@edit')->name('post.edit');
    Route::post('/edit','PostController@update');

    //投稿削除画面
    Route::get('/delete/{post}','PostController@deleteConfirm')->name('post.deleteConfirm');
    Route::post('/delete','PostController@delete');

    //コメント削除画面
    Route::get('/show/delete/{comment}','CommentController@delete')->name('show.delete');
    Route::post('/show/delete','CommentController@remove');

    //コメントへのいいね機能
    Route::post('/comment/like','LikeController@like')->name('like');
    Route::post('/comment/unlike','LikeController@unlike')->name('unlike');

    //投稿へのいいね機能
    Route::post('/postLike','LikeController@postLike')->name('post.Like');
    Route::post('/postUnlike','LikeController@postUnlike')->name('post.Unlike');

});

Route::group(['prefix' => 'upload'] ,function() {
    //投稿詳細画面から画像投稿機能
    Route::post('','UploadController@store')->name('upload');

    //画像削除機能
    Route::post('/{post}/delete','UploadController@delete')->name('upload.delete');


});

Route::group(['prefix' => 'mypage', 'middleware' => ['verified']] ,function() {
    //マイページ
    Route::get('','UserController@info')->name('myPage');

    //パスワード変更
    Route::get('/{user}/editpassword','UserController@editPassword')->name('edit.password');
    Route::post('/{user}/sendpasswordlink','UserController@sendChangePasswordLink')->name('send.password');

    //メールアドレス変更
    Route::get('/{user}/editemail','UserController@editEmail')->name('edit.email');
    Route::post('/editemail/sendemaillink','UserController@sendChangeEmailLink')->name('send.email');

    //地域変更
    Route::get('/{user}/editprefectures','UserController@editPrefectures')->name('edit.pref');
    Route::post('/{user}/editprefectures','UserController@updatePrefectures')->name('edit.pref');

});

Route::prefix('reset')->group(function() {
//メールアドレスリセットのトークン確認
Route::get('email/{token}','UserController@updateEmail');

//パスワードリセットのトークン確認
Route::get('password/{token}','UserController@updatePassword');
});

//ゲストユーザーでログイン
Route::get('guest','Auth\LoginController@guestLogin')->name('guest');