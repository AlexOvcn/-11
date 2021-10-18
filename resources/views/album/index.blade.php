@extends('master')
@extends('user.index')

@section('page', 'Главная')
@section('title', $page)

@section('content')
    <div class="gridContainer" id="grid_container">
        @if (count($albums) < 1)
            <p class="collectionAlbums-empty">Пока что здесь нет ни одного альбома</з>
        @endif
        @foreach ($albums as $album)
            <a href="{{route('album.show', $album->id)}}" class="grid-item grid-item__inGallery" style="background-image: url('{{$album->album_cover !== null ? asset('uploads/'. $album->album_cover) : asset('assets/img/hasNotCoverAlbum.png')}}')">
                <p class="album-title album-title__inCover">{{$album->album_name}}</p>
                <p class="album-artist album-artist__inCover">{{$album->artist_name}}</p>
            </a>
        @endforeach
    <div>
@endsection
