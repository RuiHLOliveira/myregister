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

Route::resource('tasks', 'TasksController')->middleware('auth');

Route::resource('situations', 'SituationsController')->middleware('auth');

Route::get('/tasks/lists/tickler', 'TasksController@tickler')->middleware('auth')->name('tasks.tickler');
Route::get('/tasks/lists/waitingfor', 'TasksController@waitingfor')->middleware('auth')->name('tasks.waitingfor');
Route::get('/tasks/lists/recurring', 'TasksController@recurring')->middleware('auth')->name('tasks.recurring');
Route::get('/tasks/lists/next', 'TasksController@next')->middleware('auth')->name('tasks.next');
Route::get('/tasks/lists/readlist', 'TasksController@readlist')->middleware('auth')->name('tasks.readlist');
Route::get('/tasks/lists/somedaymaybe', 'TasksController@somedaymaybe')->middleware('auth')->name('tasks.somedaymaybe');
Route::get('/tasks/completeTask/{id}', 'TasksController@completeTask')->middleware('auth')->name('tasks.completeTask');

Route::post('/tasks/taskToProject/{id}', 'TasksController@taskToProject')->middleware('auth')->name('tasks.taskToProject');

Route::get('/projects', 'ProjectsController@index')->middleware('auth')->name('projects.index');
Route::get('/projects/{id}/edit', 'ProjectsController@edit')->middleware('auth')->name('projects.edit');

Route::put('/projects/{id}', 'ProjectsController@update')->middleware('auth')->name('projects.update');
Route::delete('/projects/{id}', 'ProjectsController@destroy')->middleware('auth')->name('projects.destroy');

Route::get('/project/completeProject/{id}', 'ProjectsController@completeProject')->middleware('auth')->name('projects.completeProject');


Route::resource('invitations', 'InvitationTokenController')->middleware('auth');
