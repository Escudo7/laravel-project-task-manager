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
    $message = [
        'success' => session('success'),
        'warning' => session('warning'),
        'error' => session('error')
    ];
    return view('start', compact('message'));
})->name('start');

Auth::routes();

Route::get('users/{user}/edit_password', 'UserController@edit_password')
    ->name('users.edit_password');

Route::patch('users/{user}/update_password', 'UserController@update_password')
    ->name('users.update_password');

Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
