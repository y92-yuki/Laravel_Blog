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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('post','PostController@index')->middleware('auth');
Route::get('/post/add','PostController@add')->name('post.add')->middleware('auth');
Route::post('/post/add','PostController@create');
Route::get('/post/show/{post_id}','PostController@show')->name('post.show')->middleware('auth');
Route::post('/post/show','CommentController@addComment');
Route::get('/post/edit/{post_id}','PostController@edit')->name('post.edit')->middleware('auth');
Route::post('/post/edit','PostController@update');
Route::get('/post/delete/{post_id}','PostController@delete')->name('post.delete')->middleware('auth');
Route::post('/post/delete','PostController@remove');
Route::get('/post/show/delete/{comment_id}','CommentController@delete')->name('show.delete')->middleware('auth');