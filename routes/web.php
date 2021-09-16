<?php

use App\Http\Controllers\NewsController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/news/all', [NewsController::class, 'showAllNews'])->name('layouts.allNews');
Route::get('/news/add', [NewsController::class, 'addNews'])->name('layouts.addNews');
Route::post('/news/add', [NewsController::class, 'creatingNews'])->name('layouts.creatingNews');
Route::get('/news/{news}', [NewsController::class, 'showNews'])->name('layouts.news');
