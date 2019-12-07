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

Auth::routes();

Route::resource('/', 'HomeController', ['only' => 'index', 'names' => ['index' => 'home.index']]);

Route::resource('users', 'UserController', ['except' => ['create', 'store']]);

Route::resource('tasks', 'TaskController', ['except' => ['destroy']]);

Route::resource('users.comments', 'UserCommentController', ['only' => ['store']]);

Route::resource('task_statuses', 'TaskStatusController', ['except' => ['show']]);

Route::resource('lang/{locale}', 'LocalizationController', ['only' => ['index']]);
