<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $albums = Album::with('artist')->get();  // без orderBy

        $albums = DB::table('albums')  // аналог FROM (SQL) (работает только для одной таблицы)
                    ->join('artists', 'albums.artist_id', '=', 'artists.id')    // соединяем таблицы
                    ->orderBy('artists.artist_name', 'ASC')    // сортируем по имени исполн.
                    ->select('albums.*', 'artists.artist_name')     // выбираем поля которые хотим получить в контексте обьекта $albums
                    ->where('confirmed', 1)
                    ->get();

        return view('album.index', [
            'page' => 'Все наши альбомы',
            'albums' => $albums
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = Artist::orderBy('artist_name', 'asc')->get();
        $genres = Genre::orderBy('genre', 'asc')->get();

        if (Auth::check()) {
            return view('album.create', [
                'page' => 'Добавление нового альбома',
                'artists' => $artists,
                'genres' => $genres
            ]);
        }
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // следующая конструкция симулирует проверку по составному ключу, firstOr() находит соответствующую запись из БД и возвращает ее в противном случае запускает callback функцию переданную ей
        $album = Album::where('album_name', $request->album_name)->where('artist_id', $request->artist_id)->firstOr(function() {
            return null;
        });

        if ($album !== null) {
            return Response::json([
                'unique' => false         // найдено совпадение
            ]);
        } else {

            // подгоняем значения для запросов к БД (вся информация песен приходит в строковом формате, значения разделены запятой)
            $song_stringSource = $request->songs_array;
            $song_arraySource = explode(',', $song_stringSource);
            $countIter = count($song_arraySource) / 4;
            $song_arrayNew = [];
            $arraySongNames = [];
            $posName = 0;
            $posArt = 1;
            $posDurat = 2;
            $posText = 3;
            for ($i = 0; $i < $countIter; $i++) {
                $song_arrayNew[] =  [
                    'song_name' => $song_arraySource[$posName],
                    'artist_id' => $song_arraySource[$posArt],
                    'song_duration' => $song_arraySource[$posDurat],
                    'song_text' => $song_arraySource[$posText],
                ];
                $arraySongNames[] = $song_arraySource[$posName];
                $posName+=4;
                $posArt+=4;
                $posDurat+=4;
                $posText+=4;
            }

            // после перебора имеем два нужных нам массива $song_arrayNew и $arraySongNames, начнем с записи песен в таблицу songs
            Song::insert($song_arrayNew); // insert() этот метод позволяет вставлять несколько строк значений, массив в аргументе имеет формат двумерного массива с именами ключей совпадающими с колонками в БД

            // создаем альбом
            if ($request->album_cover === null) {
                $album_cover = null;
            } else {
                $album_cover = self::saveCover($request->album_name,$request->album_cover);
            }
            Album::insert([
                'album_name' => $request->album_name,
                'artist_id' => $request->artist_id,
                'label' => $request->label,
                'country' => $request->country,
                'release_date' => $request->release_date,
                'genre_id' => $request->genre_id,
                'album_cover' => $album_cover,
                'confirmed' => Auth::user()->role_id === 1 ? 0 : 1,
            ]); // в отличии от других методов insert() просто возвращает true или false. Его преимущество — в том, что можно вставить несколько записей за раз

            // находим id всех добавленных песен
            $songsId = Song::whereIn('song_name', $arraySongNames)->pluck('id')->first();        // whereIn() находит все строки по значениям переданные в массиве (2ой аргумент) ища в колонке song_name, а pluck() группирует значения всех строк из колонки id в один массив

            // связываем песни с альбомом используя промеж. таблицу
            Album::where('album_name', $request->album_name)->where('artist_id', $request->artist_id)->first()->songs()->attach($songsId);   // attach может принимать массив, все значения будут связаны с Id найденной в контексте найденного элемента

            return Response::json([
                'unique' => true,                   // совпадений нет
                'album_name' => $request->album_name,
                'redirect' => route('album.index')
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::find($id)->load(['artist', 'genre']);
        $songs = $album->songs()->get();
        $comments = Comment::where('album_id', $id)
                            ->where('confirmed', 1)
                            ->get()
                            ->load('user');
        $commentsEmpty = count($comments) !== 0 ? false : true;
        $user = Auth::user();

        return view('album.show', [
            'page' => $album->album_name,
            'album' => $album,
            'songs' => $songs,
            'count' => $count = 0,
            'comments' => $comments,
            'commentsEmpty' => $commentsEmpty,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax_uniquenessOfSong(Request $request)
    {
        $artist_name = Artist::find($request->artist_id)->artist_name;
        $song = Song::where('song_name', $request->song_name)->where('artist_id', $request->artist_id)->firstOr(function() {
            return null;
        });
        if ($song !== null) {
            return Response::json([
                'unique' => false         // найдено совпадение
            ]);
        } else {
            return Response::json([
                'unique' => true,                   // совпадений нет
                'song_name' => addslashes($request->song_name),
                'artist_name' => $artist_name,
                'artist_id' => addslashes($request->artist_id),
                'song_duration' => addslashes($request->song_duration),
                'song_text' => addslashes($request->song_text),
                'path_icon' => asset('assets/img/song-icon.png')
            ]);
        }
    }

    public function ajax_searchAlbum(Request $request) {

        $albums = DB::table('albums')  // аналог FROM (SQL) (работает только для одной таблицы)
                    ->join('artists', 'albums.artist_id', '=', 'artists.id')    // соединяем таблицы
                    ->orderBy('artists.artist_name', 'ASC')    // сортируем по имени исполн.
                    ->select('albums.*', 'artists.artist_name')     // выбираем поля которые хотим получить в контексте обьекта $albums
                    ->where('confirmed', 1)
                    ->where('album_name', 'LIKE', "{$request->text}%")  // поиск по назв. альбома
                    ->orWhere('artist_name', 'LIKE', "{$request->text}%")   // ИЛИ поиск по имени исполнителя
                    ->get();

        // передаем относительные пути
        $album_url = route('album.show', false);    // т.к. роут ожидает вторым параметром id, нужно что-то передать, при такой записи он не ругается, но и ничего не вставляет в конец url
        $img_url = asset('uploads/');
        $img_url_hasNot = asset('assets/img/hasNotCoverAlbum.png');

        return Response::json([
            'text' => $request->text,
            'albums' => $albums,
            'album_url' => $album_url,
            'img_url' => $img_url,
            'img_url_hasNot' => $img_url_hasNot

        ]);
    }

    static function saveCover($albume_name,$file)
    {
        if (! $file) { return; }

        $ext = $file->extension();
        $filename = Str::random(3) . $albume_name . Str::random(3) . '.' . $ext;

        return $file->storeAs('images', $filename, 'uploads');
    }
}
