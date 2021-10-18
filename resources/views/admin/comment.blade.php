@extends('master')
@extends('user.index')

@section('page', $page)
@section('title', $page)

@section('content')
    @if (count($comments) < 1)
        <p class="commentBlockFromAdmin-notHas">Неподтвержденных сообщений нет!</p>
    @endif

    @foreach ($comments as $comment)
        <div class="flex-block commentBlockFromAdmin">
            <a href="{{route('admin.comment.viewAlbum', [$comment->id, $comment->album_id])}}" class="grid-item grid-item__inGallery" style="background-image: url('{{$comment->album_cover !== null ? asset('uploads/'. $comment->album_cover) : asset('assets/img/hasNotCoverAlbum.png')}}'); width: 227px; margin: 0">
                <p class="album-title album-title__inCover">{{$comment->album_name}}</p>
                <p class="album-artist album-artist__inCover">{{$comment->artist_name}}</p>
            </a>
            <div class='comment' style="width: 730px; padding: 0; margin-left: 30px;">
                <div class='comment-info'>
                    <div class='comment-info__avatar' style="background-image: url('{{$comment->user_avatar !== null ? asset('uploads/'.$comment->user_avatar) : asset('assets/img/hasNotAvatar.jpg')}}');"></div>
                    <p class='comment-info__username'>Имя: {{$comment->user_name}}</p>
                    <p class='comment-info__status'>Статус: <span style="color: {{$comment->user_status ? 'orangered' : 'yellowgreen'}}">{{$comment->user_status ? 'забанен' : 'активен' }}</span></p>
                    <p class='comment-info__sendingTime' value='{{$comment->created_at}}'>Дата написания: </p>
                </div>
                <div class='comment-textField' style="height: 227px; border-radius: 15px;">
                    <p class='comment-textField__text'>{{$comment->comment}}</p>
                </div>
            </div>
            <div class="flex-block btnBlockFromAdmin">
                <a class="btn confirmation-btn" onclick="messageConfirmation(this, {{$comment->id}})">Одобрить</a>
                <a class="btn cancel-btn" onclick="messageDelete(this, {{$comment->id}})">Удалить</a>
            </div>
        </div>
    @endforeach
@endsection
