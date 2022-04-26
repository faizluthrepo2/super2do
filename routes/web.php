<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task;

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
    return view('index');
});

Route::post('/api/insert_task', [Task::class, 'insert']);
Route::get('/api/show_task', [Task::class, 'show']);
Route::get('/api/update_status/{id}', [Task::class, 'update']);
Route::get('/api/show_active', [Task::class, 'active']);
Route::get('/api/show_completed', [Task::class, 'completed']);
Route::get('/api/completed_all', [Task::class, 'completedall']);
Route::get('/api/delete_all', [Task::class, 'deleteall']);
