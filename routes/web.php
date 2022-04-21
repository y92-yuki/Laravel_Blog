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

//投稿一覧画面
Route::get('post','PostController@index')->name('post')->middleware(['verified']);

//新規投稿画面
Route::get('/post/create','PostController@create')->name('post.create')->middleware('auth');
Route::post('/post/create','PostController@store');

//投稿詳細画面
Route::get('/post/show/{post_id}','PostController@show')->name('post.show')->middleware('auth');
Route::post('/post/show','CommentController@addComment');

//投稿編集画面
Route::get('/post/edit/{post}','PostController@edit')->name('post.edit')->middleware('auth');
Route::post('/post/edit','PostController@update');

//投稿削除機能
Route::get('/post/delete/{post}','PostController@deleteConfirm')->name('post.deleteConfirm')->middleware('auth');
Route::post('/post/delete','PostController@delete');

//コメント削除画面
Route::get('/post/show/delete/{comment}','CommentController@delete')->name('show.delete')->middleware('auth');
Route::post('/post/show/delete','CommentController@remove');

//コメントへのいいね機能
Route::post('/post/comment/like','LikeController@like')->name('like');
Route::post('/post/comment/unlike','LikeController@unlike')->name('unlike');

//投稿へのいいね機能
Route::post('/post/postLike','LikeController@postLike')->name('post.Like');
Route::post('/post/postUnlike','LikeController@postUnlike')->name('post.Unlike');

//投稿詳細画面からの画像投稿機能
Route::post('/upload','UploadController@store')->name('upload');

//画像削除機能
Route::post('/upload/{post}/delete','UploadController@delete')->name('upload.delete');

//my page
Route::get('/mypage','UserController@info')->name('myPage')->middleware('auth');

//パスワード変更
Route::get('/mypage/{user}/editpassword','UserController@editPassword')->name('edit.password')->middleware('auth');
Route::post('/mypage/{user}/editpassword','UserController@updatePassword')->name('edit.password');

//メールアドレス変更画面
Route::get('/mypage/{user}/editemail','UserController@editEmail')->name('edit.email')->middleware('auth');

Route::post('/mypage/editemail/sendemaillink','UserController@sendChangeEmailLink')->name('send.email');

Route::get('reset/{token}','UserController@reset');