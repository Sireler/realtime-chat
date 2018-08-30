<?php

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

Route::get('/home', 'HomeController@index')->name('home');

// Chat
Route::get('/chat', 'ChatController@index')->name('chat');
Route::post('/chat', 'ChatController@postMessage')->name('sendMessage');
Route::get('/chat/load', 'ChatController@loadMessages');
Route::get('/find', 'ChatController@findUser');

// User
Route::get('/profile', 'UserController@profile')->name('profile');
Route::get('/user/info', 'UserController@getUserInfo');
Route::post('/profile/avatar', 'UserController@changeAvatar')->name('changeAvatar');


// Socket
Route::get('/socket/check-auth', 'SocketController@checkAuth')->name('socket.check_auth');