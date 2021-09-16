@extends('master')

@section('page', 'Страница с новостью') {{-- передаем значение переменной page, на родительский шаблон, далее можем ее обьявить к пример так @yield('page') --}}

<div class="container">

    <h1 class="title">{{$news->summary}}</h1>
    <h3 class="description">{{$news->short_description}}</h3>
    <p class="description">{{$news->full_text}}</p>
    <p id='time' time='{{ isset($news->created_at) ? $news->created_at : "дата не задана" }}'>Дата публикации: </p>

</div>

<script>
    //  событие происходит при загрузке html css и js контента
    window.addEventListener('DOMContentLoaded', function() {
        // находим элемент
        let dateText = document.querySelector('#time');
        // получаем дату
        let data = localDate(dateText.getAttribute('time'));
        // вставляем ее в конец содержимого тега <p>
        time.insertAdjacentText('beforeend', data);
    });
</script>

