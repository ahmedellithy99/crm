<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::resource('clients' , ClientController::class)->except('show')->middleware('auth');
// Route::get('/clients' , [ClientController::class , 'index'])->name('clients.index');
// Route::get('/clients/create' , [ClientController::class , 'create'])->name('clients.create');
// Route::post('/clients/create' , [ClientController::class , 'store'])->name('clients.store');
// Route::get('/clients/{client}/edit' , [ClientController::class , 'edit'])->name('clients.edit');
// Route::put('/clients/{client}' , [ClientController::class , 'update'])->name('clients.update');
// Route::delete('/clients/{client}' , [ClientController::class , 'destroy'])->name('clients.destroy');

Route::resource('projects' , ProjectController::class)->middleware('auth');
Route::resource('tasks' , TaskController::class)->middleware('auth');







