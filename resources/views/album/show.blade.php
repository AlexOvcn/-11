@extends('master')
@extends('user.index')

@section('page', 'Просмотр альбома - "' . $page.'"')
@section('title', $page)

@section('content')
    <div class="flex-block" style="align-items: flex-start;">
        <div class="grid-item grid-item__outOfGallery" style="background-image: url('{{$album->album_cover !== null ? asset('uploads/'. $album->album_cover) : asset('assets/img/hasNotCoverAlbum.png')}}')">
        </div>
        <div class="album-descriptionBlock">
            <p class="album-artist" style="margin-top: 20px;">Музыкальный исполнитель: {{$album->artist->artist_name}}</p>
            <p class="album-otherInfo">Жанр: {{$album->genre->genre}}</p>
            <p class="album-otherInfo">Лэйбл: {{$album->label === null ? 'не указан' : $album->label}}</p>
            <p class="album-otherInfo">Страна: {{$album->country === null ? 'не указана' : $album->country}}</p>
            <p class="album-otherInfo">Дата релиза: {{$album->release_date}}</p>
        </div>
    </div>
    @foreach ($songs as $song)
        <div class="album-songBlock flex-block" style="justify-content: flex-start">
            <p class="song-item">{{$count += 1}}</p>
            <img class="song-item" src="{{asset('assets/img/song-icon.png')}}" width="25px" style="margin-left: 10px">
            <p class="song-item">Название: {{$song->song_name}}</p>
            <p class="song-item">Длительность: {{$song->song_duration}}</p>
            <p class="song-showTextOfSong" onclick="show_songText({{$song->id}})" id="song-showText{{$song->id}}">Посмотреть текст песни ⮟</p>
        </div>
        <div id="song-text{{$song->id}}" class="songText songText-hidden">{{$song->song_text}}</div>
    @endforeach

    <div class='commentsBlock'>
        @if ($commentsEmpty)
            <h3 class='comment-hasNotComments'>Пока еще никто не оставил комментарий!</h3>
        @else
            @foreach ($comments as $comment)

                <div class='comment {{(isset($id_not_confirmed_comment) && (String)$comment->id === $id_not_confirmed_comment) ? 'comment-notConfirmed' : null}}'>
                    <div class='comment-info'>
                        <div class='comment-info__avatar' style="background-image: url('{{$comment->user->avatar !== null ? asset('uploads/'.$comment->user->avatar) : asset('assets/img/hasNotAvatar.jpg')}}');"></div>
                        <p class='comment-info__username'>Имя: {{$comment->user->name}}</p>
                        <p class='comment-info__status'>Статус: <span style="color: {{$comment->user->status ? 'orangered' : 'yellowgreen'}}">{{$comment->user->status ? 'забанен' : 'активен' }}</span></p>
                        <p class='comment-info__sendingTime' value='{{$comment->created_at}}'>Дата написания: </p>
                    </div>
                    <div class='comment-textField'>
                        <p class='comment-textField__text'>{{$comment->comment}}</p>
                    </div>
                </div>

            @endforeach
        @endif
    </div>
    <div class='commentsBlock' style="margin-top: 20px; width: 55%; border-radius: 8px 8px 0 8px">
        <div class='comment'>
            <div class='comment-info'>
                <div class='comment-info__avatar' style="background-image: url('{{$user !== null && $user->avatar !== null ? asset('uploads/'.$user->avatar) : asset('assets/img/hasNotAvatar.jpg')}}');"></div>
                <p class='comment-info__username'>Имя: {{$user !== null ? $user->name : 'гость'}}</p>
                @if (isset($user))
                    <p class='comment-info__status'>Статус: <span style="color: {{$user->status ? 'orangered' : 'yellowgreen'}}">{{$user->status ? 'забанен' : 'активен' }}</span></p>
                @else
                    <p class='comment-info__status'>Статус: <span style="color: rgb(255, 217, 0)">не залогинен</span></p>
                @endif
            </div>
            @if (isset($user))
                <textarea class='comment-textField textArea' id="addCommentField"></textarea>
            @else
                <div class='comment-textField'>
                    <h3 class='comment-hasNotLogin'>Только авторизованные пользователи могут оставлять комментарии!</h3>
                </div>
            @endif
        </div>
        @if (isset($user))
            <button class="btn btn-add floatRight" style="border-radius: 0 0 4px 4px;margin: 1px -1px 0 0; border-top: none" id="btn-addComment" onclick="addComment({{$album->id}})">Добавить комментарий</и>
        @endif
    </div>
    @if (!$album->confirmed)
        <div class="linksBlockFromAdminPanel-album">
            <p class="linksBlockFromAdminPanel-album__title">Ваш вердикт</p>
            <div class="flex-block" style="justify-content: space-evenly">
                <a href="{{route('admin.album.verdict.confirm', $album->id)}}" class="btn btn-addBig confirmation-btn">Одобрить альбом</a>
                <a href="{{route('admin.album.verdict.delete', $album->id)}}" class="btn btn-addBig cancel-btn">Удалить насовсем</a>
            </div>
        </div>
    @endif
@endsection
