<?php

use App\Http\Controllers\AutoController;
use App\Http\Controllers\Role_userController;
use App\Http\Controllers\UserController;
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

Route::resource('cars', AutoController::class);

Route::get('auth/login', [UserController::class, 'loginForm'])->name('auth.loginForm');
Route::post('auth/login', [UserController::class, 'login'])->name('auth.login');

Route::get('auth/register', [UserController::class, 'registerForm'])->name('auth.registerForm');
Route::post('auth/register', [UserController::class, 'register'])->name('auth.register');
Route::get('auth/logout', [UserController::class, 'logout'])->name('auth.logout');


Route::middleware(['admin', 'auth'])->prefix('admin')->group(function() {

    Route::get('/index', [Role_userController::class, 'index'])->name('admin.index');

	Route::post('/ajax-getRoles', [Role_userController::class, 'ajaxGetRoles'])->name('admin.ajax-getRoles');

    Route::post('/ajax-getRolesForActionDeleteOneRole', [Role_userController::class, 'ajaxGetRolesForActionDeleteOneRole'])->name('admin.ajax-getRolesForActionDeleteOneRole');

    Route::post('/ajax-getRolesForActionAddOneRole', [Role_userController::class, 'ajaxGetRolesForActionAddOneRole'])->name('admin.ajax-getRolesForActionAddOneRole');

    Route::delete('/ajax-detachOneRole', [Role_userController::class, 'ajaxDetachOneRole'])->name('admin.ajax-detachOneRole');

    Route::post('/ajax-attachOneRole', [Role_userController::class, 'ajaxAttachOneRole'])->name('admin.ajax-attachOneRole');

});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';
