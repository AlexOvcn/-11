<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Comment;
use App\Models\Role;
use App\Models\Song;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\ConfirmPassword;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerForm()
    {
        return view('user.register', [
            'page' => 'Регистрация'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'pass' => 'required|min:6',
            'confirm_password' => ['required', new ConfirmPassword($request->pass)],
            'avatar' => 'max:2000|mimes:jpeg,jpg,png'   // в килобайтах
        ]); // добавление собственного правила ConfirmPassword проверяющий значение с полем password

        if ($request->avatar === null) {
            $avatar = null;
        } else {
            $avatar = self::saveAvatar($request->email,$request->avatar);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->pass),
            'avatar' => $avatar,
            'role_id' => 1
        ]);

        // $request->request->add(['password' => $request->pass]); // мы имеем в текущем request поле pass которое в след функции не валиден, поэтому мы добавляем новое поле (как вариант авторизации)
        // return $this->login($request);

        Auth::login($user);     // функция автоматически делает вход дл пользователя (метод класса Auth)
        return redirect()->route('album.index');
    }

    public function loginForm()
    {
        return view('user.login', [
            'page' => 'Авторизация'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user?->status) {        // если статус 1 (Забанен)
            return back()->withErrors([
                'loginFail' => 'Этот аккаунт заблокирован!'
            ])->withInput()->with([
                'info' => 'banned'
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('album.index');
        }

        return back()->withErrors([
            'loginFail' => 'Проверьте правильность введенных данных'
        ])->withInput();
    }

    public function logout(Request $request)        // аргумент передается неявно
    {
        Auth::logout();

        $request->session()->invalidate();      // в дополнение к вызову logout метода рекомендуется аннулировать сеанс пользователя

        $request->session()->regenerateToken();     // ..и перегенерировать его маркер CSRF


        // в дополнение к вызову logout метода рекомендуется аннулировать сеанс пользователя и восстановить его маркер CSRF.

        return redirect()->route('album.index');
    }

    public function admin_index()
    {
        $users = User::orderBy('name', 'asc')->get();
        $artists = Artist::orderBy('artist_name', 'asc')->get();

        return view('admin.index', [
            'page' => 'Панель администратора',
            'users' => $users,
            'artists' => $artists
        ]);
    }

    public function admin_album()
    {

        $albums = DB::table('albums')  // аналог FROM (SQL) (работает только для одной таблицы)
                    ->join('artists', 'albums.artist_id', '=', 'artists.id')    // соединяем таблицы
                    ->orderBy('artists.artist_name', 'ASC')    // сортируем по имени исполн.
                    ->select('albums.*', 'artists.artist_name')     // выбираем поля которые хотим получить в контексте обьекта $albums
                    ->where('confirmed', 0)
                    ->get();


        return view('album.index', [
            'page' => 'Все неподтвержденные альбомы',
            'albums' => $albums
        ]);
    }

    public function admin_album_verdictСonfirm($id)
    {

        Album::find($id)?->update([             // если альбом уже был удален на момент нажатия
            'confirmed' => 1
        ]);

        return redirect()->route('admin.album');
    }

    public function admin_album_verdictDelete($id)
    {
        $album = Album::find($id);

        if ($album === null) {
            return redirect()->route('admin.album');        // если альбом уже был удален на момент нажатия
        }

        $songsIdArr = $album->songs()->get()->pluck('id');
        $commentsIdArr = $album->comments()->get()->pluck('id');

        // удаляем связи альбома с песнями
        $album->songs()->detach();

        // удаляем песни
        Song::destroy($songsIdArr);

        // удаляем комменты
        Comment::destroy($commentsIdArr);

        // удаляем картинку обложки из локального хранилища
        $album->removeImage();

        // удаляем альбом
        $album->delete($commentsIdArr);

        return redirect()->route('admin.album');
    }

    public function admin_comment()
    {
        $comments = DB::table('comments')  // аналог FROM (SQL) (работает только для одной таблицы)
                    ->join('users', 'comments.user_id', '=', 'users.id')    // соединяем таблицы
                    ->join('albums', 'comments.album_id', '=', 'albums.id')
                    ->join('artists', 'albums.artist_id', '=', 'artists.id')
                    ->orderBy('comments.created_at', 'desc')    // выводим сначала свежие комментарии
                    ->select('comments.*', 'users.name AS user_name', 'users.status AS user_status', 'users.avatar AS user_avatar', 'albums.album_name', 'albums.album_cover', 'artists.artist_name')     // выбираем поля которые хотим получить в контексте обьекта $comments
                    ->where('comments.confirmed', 0)
                    ->get();

        return view('admin.comment', [
            'page' => 'Все неподтвержденные комментарии',
            'comments' => $comments
        ]);
    }

    public function admin_comment_viewAlbum($comment_id, $album_id)
    {
        $album = Album::find($album_id)->load(['artist', 'genre']);
        $songs = $album->songs()->get();
        $comments = Comment::where('album_id', $album_id)
                            ->where('confirmed', 1)
                            ->orWhere('id', $comment_id)
                            ->get()
                            ->load('user');
                            dd($comments);
        $commentsEmpty = count($comments) !== 0 ? false : true;
        $user = Auth::user();

        return view('album.show', [
            'page' => $album->album_name,
            'album' => $album,
            'songs' => $songs,
            'count' => $count = 0,
            'comments' => $comments,
            'commentsEmpty' => $commentsEmpty,
            'user' => $user,
            'id_not_confirmed_comment' => $comment_id
        ]);
    }
    public function comment_verdictConfirm($id)
    {
        Comment::find($id)?->update([       // если коммент уже был удален (?->) не запустит update() (то есть поиск вернет null)
            'confirmed' => 1,
        ]);
    }

    public function comment_verdictDelete($id)
    {
        Comment::find($id)?->delete();      // если коммент уже был удален (?->) не запустит delet() (то есть поиск вернет null)
    }

    public function user_showInfo($id)
    {
        $user_info = User::find($id)->load('role');

        $user_avatar = $user_info->avatar === null ? asset('assets/img/hasNotAvatar.jpg') : asset('uploads/'.$user_info->avatar);

        return Response::json([
            'user_info' => $user_info,
            'user_avatar' => $user_avatar
        ]);
    }

    public function user_actions($action, $id)
    {
        $user = User::find($id);

        switch ($action) {
            case 0:
                $user->update([
                    'status' => 0,
                ]);
                break;
            case 1:
                $user->update([
                    'status' => 1,
                ]);
                break;
            case 2:
                $user->update([
                    'role_id' => 1,
                ]);
                break;
            case 3:
                $user->update([
                    'role_id' => 2,
                ]);
                break;
        }
    }

    public function artist_select_refresh()
    {
        $artists = Artist::orderBy('artist_name', 'asc')->get();

        return Response::json([
            'artists' => $artists
        ]);
    }

    public function artist_delete($id)
    {
        Artist::find($id)?->delete();
    }

    public function artist_add($artist_name)
    {
        $artist = Artist::firstOrCreate(['artist_name' => $artist_name]);       // вернет запись если она существует или вернет созданную запись
        $status = '';

        if ($artist->wasRecentlyCreated) {      // данная конструкция позволит определить найдена или создана была запись
            $status = 'Создан';     // пользователь не найден и был создан
        } else {
            $status = 'Найден';     // пользователь был найден
        }

        return Response::json([
            'artist' => $artist,
            'status' => $status
        ]);
    }

    static function saveAvatar($email,$file)
    {
        if (! $file) { return; }

        $ext = $file->extension();
        $filename = Str::random(3) . $email . Str::random(3) . '.' . $ext;

        $image = \Image::make($file);
        $imagePath = base_path('public/uploads/images/' . $filename);

        $image->resize(null, 100, function ($constraint) {     // пропорциональное изменение сторон (перв аргум ширина, второй высота) мы выбираем высоту и по ней будет делатся ресайз
            $constraint->aspectRatio();
        });

        $image->save($imagePath);

        $path = 'images/' . $filename;

        return $path;
    }
}
