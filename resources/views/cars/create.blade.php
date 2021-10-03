@extends('master')
@extends('header.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <form action="{{route('cars.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="inputName"><span>Модель</span><input class="input" type="text" name="name" placeholder="Например, Бибика"></label>
        @error('name')
            <span style="color:red">{{ $message }}</span>
        @enderror
        <label class="inputName"><span>Описание</span><textarea class="input" rows="6" name="description" style="resize: vertical"></textarea></label>
        <label class="inputName"><span>Цена</span><input class="input" type="text" name="price"></label>
        <label class="inputName"><span>Выберите иконку</span><input class="input" type="file" name="image_path" accept="image/jpeg,image/png"></label>
        <label class="inputName"><span>Выберите изображения для галлереи (макс. 3 картинки)</span><input class="input" multiple type="file" name="imagesForGallery[]" accept="image/jpeg,image/png"></label>
        <button type="submit" class="buttonAdd">Создать запись</button>
    </form>
@endsection
