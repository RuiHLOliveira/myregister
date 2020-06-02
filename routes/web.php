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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Auth::routes();

Route::get('/dashboard', 'DashboardsController@index')->name('dashboardIndex')->middleware('auth');

Route::get('tasks/situation/{situation}', 'TasksController@index')->middleware('auth')->name('tasks.index.situation');
Route::resource('tasks', 'TasksController')->middleware('auth');
Route::resource('projects', 'ProjectsController')->middleware('auth');
