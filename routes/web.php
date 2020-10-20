<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TdlistController;
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

Route::get('/', HomeController::class)->name('dashboard');

//lists routes
Route::get('lists/create', [TdlistController::class, 'create'])->name('lists.create');
Route::get('lists/{id}', [TdlistController::class, 'show'])->name('lists.show');
Route::post('/', [TdlistController::class, 'store'])->name('lists.store');
Route::get('lists/{id}/edit', [TdlistController::class, 'edit'])->name('lists.edit');
Route::put('lists/{id}', [TdlistController::class, 'update'])->name('lists.update');
Route::delete('lists/{id}/delete', [TdlistController::class, 'destroy'])->name('lists.destroy');
//tasks routes
Route::post('lists/{id}/task/store', [TaskController::class, 'store'])->name('tasks.store');
Route::get('task/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::get('task/{list_id}/sortBy/{state}/{priority}', [TaskController::class, 'sortBy'])->name('tasks.sortByState');
Route::put('task/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('task/{id}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Route::get('/', function () {
//     return view('welcome');
// });
