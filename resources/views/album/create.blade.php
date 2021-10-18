@extends('master')
@extends('user.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <div class="flex-block" style="align-items: flex-start">
        <form action="Действие отменено" enctype="multipart/form-data" id='formAddAlbum'>
            @csrf
            <label class="inputName" style="margin-top: 0">
                <span>*Название альбома</span>
                <input class="input" type="text" name="album_name">
            </label>
            <label class="inputName">
                <span>*Выбор исполнителя</span>
                <select name="artist_id" class="input">
                    <option value="">Выберите исполнителя</option>
                    @foreach ($artists as $artist)
                        <option value="{{$artist->id}}">{{$artist->artist_name}}</option>
                    @endforeach
                </select>
            </label>
            <label class="inputName">
                <span>*Выбор жанра</span>
                <select name="genre_id" class="input">
                    <option value="">Выберите жанр</option>
                    @foreach ($genres as $genre)
                        <option value="{{$genre->id}}">{{$genre->genre}}</option>
                    @endforeach
                </select>
            </label>
            <label class="inputName">
                <span>*Дата релиза</span>
                <input class="input" type="date" name="release_date">
            </label>
            <label class="inputName">
                <span>Обложка альбома</span>
                <input class="input" type="file" name="album_cover" accept="image/jpeg,image/png">
            </label>
            <label class="inputName">
                <span>Лейбл</span>
                <input class="input" type="text" name="label">
            </label>
            <label class="inputName">
                <span>Страна</span>
                <input class="input" type="text" name="country">
            </label>
            <button type="submit" class="btn btn-addBig" style="margin-top: 30px">Создать альбом</button>
            {{-- <a class="btn btn-addBig" style="margin-left: 30px">Закончить добавление плейлиста</a> --}}
        </form>
        <div>
            <div id="stack-songs"></div>
            <fieldset class="fieldOfBlockSongs">
                <legend>Добавление песен</legend>
                <form action="действие отменено" id="formAddSong">
                    @csrf
                    <label class="inputName" style="margin-top: 0">
                        <span>*Название песни</span>
                        <input class="input" type="text" name="song_name">
                    </label>
                    <label class="inputName">
                        <span>*Выбор исполнителя</span>
                        <select name="artist_id" class="input">
                            <option value="">Выберите исполнителя</option>
                            @foreach ($artists as $artist)
                                <option value="{{$artist->id}}" {{(string)$artist->id === old('artist_id') ? 'selected' : null}} >{{$artist->artist_name}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="inputName" id="song_duration">
                        <span>*Длительность трека</span>
                        <div class="flex-block; justify-content: flex-start;">
                            <input class="input" type="text" name="song_duration_minutes" style="width: 38px; padding: 4px 8px 2px; display: inline-block"  id="song_duration_minutes">
                            <p class="inputTimeSeparator" style="display: inline-block">:</p>
                            <input class="input" type="text" name="song_duration_seconds" style="width: 38px; padding: 4px 8px 2px; display: inline-block" id="song_duration_seconds">
                        </div>
                    </label>
                    <label class="inputName">
                        <span>*Текст песни</span>
                        <textarea class='comment-textField textArea'  name="song_text"></textarea>
                    </label>
                    <button type="submit" class="btn btn-add" style="margin-top: 20px">Прикрепить к альбому</button>
                </form>

                <div class="songsList" id="songs_list">
                    <P class="songsList-title">Список закрепленных песен</з>
                    <p class="songsList-empty">Здесь будут показаны все закрепленные песни</p>
                </div>
            </fieldset>
        </div>
    </div>
@endsection
