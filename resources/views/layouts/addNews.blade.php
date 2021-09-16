@extends('master')

@section('page', 'Страница добавления новостей')

@section('content')
    <div class="container">
        <form class="addNewsForm" action="{{route('layouts.creatingNews')}}" method="POST">
            @csrf
            <label class="addNewsForm-label"><span class="addNewsForm-label__title">Header: </span><input name="summary" type="text" class="addNewsForm-label__input" oninput="inputRestriction(50, this)" required pattern=".{2,}"></label>
            <label class="addNewsForm-label"><span class="addNewsForm-label__title">Short text: </span><input name="short_description" type="text" class="addNewsForm-label__input" oninput="inputRestriction(150, this)"  required pattern=".{2,}"></label>
            <label class="addNewsForm-label"><span class="addNewsForm-label__title">Article: </span><textarea name="full_text"  rows="20" class="addNewsForm-label__input" oninput="inputRestriction(5000, this)"  required pattern=".{2,}"></textarea></label>
            <button class="addNewsForm-btn" type="submit">Add</button>
        </form>
    </div>
@endsection
