<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CommentController;
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

Route::resource('album', AlbumController::class);
Route::post('song/ajax_uniquenessOfSong', [AlbumController::class, 'ajax_uniquenessOfSong'])->name('song.ajax_uniquenessOfSong');
Route::post('album/ajax_uniquenessOfSong', [AlbumController::class, 'ajax_searchAlbum'])->name('album.ajax_searchAlbum');

Route::prefix('user')->group(function() {

    Route::get('/login', [UserController::class, 'loginForm'])->name('user.loginForm');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');

    Route::get('/register', [UserController::class, 'registerForm'])->name('user.registerForm');
    Route::post('/register', [UserController::class, 'register'])->name('user.register');
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
});

Route::prefix('comment')->group(function() {

    Route::post('/store', [CommentController::class, 'store'])->name('comment.store');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {

    // все приведенные ниже запросы выполняются методом GET, включая и те которые изменяют данные в БД, что КРАЙНЕ НЕ РЕКОМЕНДУЕТСЯ!!
    // это выполнено лишь в ознакомительных целях и доступно лишь пользователю с ролью "админ"

    Route::get('/index', [UserController::class, 'admin_index'])->name('admin.index');
    Route::get('/album', [UserController::class, 'admin_album'])->name('admin.album');
    Route::get('/album_verdictСonfirm/{id}', [UserController::class, 'admin_album_verdictСonfirm'])->name('admin.album.verdict.confirm');
    Route::get('/album_verdictDelete/{id}', [UserController::class, 'admin_album_verdictDelete'])->name('admin.album.verdict.delete');
    Route::get('/comment', [UserController::class, 'admin_comment'])->name('admin.comment');
    Route::get('/comment/{com_id}/viewAlbum/{alb_id}', [UserController::class, 'admin_comment_viewAlbum'])->name('admin.comment.viewAlbum');
    Route::get('/comment_verdictConfirm/{id}', [UserController::class, 'comment_verdictConfirm'])->name('admin.comment.verdict.confirm');
    Route::get('/comment_verdictDelete/{id}', [UserController::class, 'comment_verdictDelete'])->name('admin.comment.verdict.delete');
    Route::get('/user_showInfo/{id}', [UserController::class, 'user_showInfo'])->name('admin.user.show.info');
    Route::get('/user_action/{action}/user/{id}', [UserController::class, 'user_actions'])->name('admin.user.actions');
    Route::get('/artist_select_refresh', [UserController::class, 'artist_select_refresh'])->name('admin.artist.select.refresh');
    Route::get('/artist_delete/{id}', [UserController::class, 'artist_delete'])->name('admin.artist.delete');
    Route::get('/artist_add/{artist_name}', [UserController::class, 'artist_add'])->name('admin.artist.add');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';
