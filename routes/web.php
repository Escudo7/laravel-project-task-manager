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

Route::patch('tasks/{task}/get_task', 'TaskController@get_task')
    ->name('tasks.get_task');

Route::patch('tasks/{task}/abandon_task', 'TaskController@abandon_task')
    ->name('tasks.abandon_task');

Route::resource('tasks', 'TaskController', ['except' => ['destroy']]);

Route::resource('users.comments', 'UserCommentController', ['only' => ['store']]);

Route::resource('task_statuses', 'TaskStatusController', ['except' => ['show']]);

Route::resource('lang/{locale}', 'LocalizationController', ['only' => ['index']]);
