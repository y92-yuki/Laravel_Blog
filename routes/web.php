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

// Auth::routes();
Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');
// Route::fallback(function() {
//     return redirect('/');
// });

Route::prefix('post')->group(function() {
    //投稿一覧画面
    Route::get('','PostController@index')->name('post')->middleware(['verified']);

    //新規投稿画面
    Route::get('/create','PostController@create')->name('post.create')->middleware('auth');
    Route::post('/create','PostController@store');

    //投稿詳細画面
    Route::get('/show/{post_id}','PostController@show')->name('post.show')->middleware('auth');

    //コメント投稿
    Route::post('/show','CommentController@addComment');

    //投稿編集画面
    Route::get('/edit/{post}','PostController@edit')->name('post.edit')->middleware('auth');
    Route::post('/edit','PostController@update');

    //投稿削除画面
    Route::get('/delete/{post}','PostController@deleteConfirm')->name('post.deleteConfirm')->middleware('auth');
    Route::post('/delete','PostController@delete');

    //コメント削除画面
    Route::get('/show/delete/{comment}','CommentController@delete')->name('show.delete')->middleware('auth');
    Route::post('/show/delete','CommentController@remove');

    //コメントへのいいね機能
    Route::post('/comment/like','LikeController@like')->name('like');
    Route::post('/comment/unlike','LikeController@unlike')->name('unlike');

    //投稿へのいいね機能
    Route::post('/postLike','LikeController@postLike')->name('post.Like');
    Route::post('/postUnlike','LikeController@postUnlike')->name('post.Unlike');

});

Route::prefix('upload')->group(function() {
    //投稿詳細画面から画像投稿機能
    Route::post('','UploadController@store')->name('upload');

    //画像削除機能
    Route::post('/{post}/delete','UploadController@delete')->name('upload.delete');


});

Route::prefix('mypage')->group(function() {
    //マイページ
    Route::get('','UserController@info')->name('myPage')->middleware('auth');

    //パスワード変更
    Route::get('/{user}/editpassword','UserController@editPassword')->name('edit.password')->middleware('auth');
    Route::post('/{user}/editpassword','UserController@updatePassword')->name('edit.password');

    //メールアドレス変更
    Route::get('/{user}/editemail','UserController@editEmail')->name('edit.email')->middleware('auth');
    Route::post('/editemail/sendemaillink','UserController@sendChangeEmailLink')->name('send.email');

    //地域変更
    Route::get('/{user}/editprefectures','UserController@editPrefectures')->name('edit.pref');
    Route::post('/{user}/editprefectures','UserController@updatePrefectures')->name('edit.pref');

});

//パスワードリセットのトークン確認
Route::get('reset/{token}','UserController@reset');

//APIデータを取得
Route::post('getForeCast','ForecastApiController@getForeCastApi');