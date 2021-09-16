@extends('master')

@section('page', 'Страница с новостями') {{-- передаем значение переменной page, на родительский шаблон, далее можем ее обьявить к пример так @yield('page') --}}

@section('content')
    <div class="container">
        <a class="btn" href="{{route('layouts.addNews')}}">Add News</a>

        @foreach ($allNews as $news)
            <hr>
            <h1 class="titleInMainPage"><a href="{{route('layouts.news', $news->id)}}">{{$news->summary}}</a></h1>
            <p class="descriptionInMainPage">{{$news->short_description}}</p>
        @endforeach
    </div>
@endsection
