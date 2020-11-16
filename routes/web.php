<?php

use Illuminate\Support\Facades\Route;

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

// главная страница - страница новостей
Route::get('/',
    'App\Http\Controllers\NewsController@all'
)->name('news');

// добавление записи
Route::get('/news-add', function () {
    return view('news');
})->middleware('auth')->name('news-add');

// вывод всех записей
Route::get('/news/all',
    'App\Http\Controllers\NewsController@all'
)->name('news-data');

// сабмит записи
Route::post('/news/submit',
    'App\Http\Controllers\NewsController@submit'
)->middleware('auth')->name('news-form');

// страница пользователей
Route::get('/users', function () {
    return view('users');
})->middleware('auth')->name('users');

Auth::routes();

// удалить позже
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

// Users
Route::get('/users', [App\Http\Controllers\UsersController::class, 'getList'])->middleware('auth')->name('users');

// Friends
Route::get('/friends', [App\Http\Controllers\FriendsController::class, 'getIndex'])->middleware('auth')->name('friends.index');
Route::get('/friends/add/{name}', [App\Http\Controllers\FriendsController::class, 'getAdd'])->middleware('auth')->name('friends.add');
Route::get('/friends/accept/{name}', [App\Http\Controllers\FriendsController::class, 'getAccept'])->middleware('auth')->name('friends.accept');

