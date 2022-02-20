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
Route::get('/post/add','PostController@add')->middleware('auth');
Route::post('/post/add','PostController@create');
Route::get('/post/show','PostController@show')->middleware('auth');
Route::post('/post/show','CommentController@addComment');
Route::get('/post/edit','PostController@edit')->middleware('auth');
Route::post('/post/edit','PostController@update');
Route::get('/post/delete','PostController@delete')->middleware('auth');
Route::post('/post/delete','PostController@remove');