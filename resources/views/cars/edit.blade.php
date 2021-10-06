@extends('master')
@extends('header.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <form action="{{route('cars.update', $auto->id)}}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <label class="inputName"><span>Модель</span><input class="input" type="text" name="name" placeholder="Например, Бибика" value="{{$auto->name}}"></label>
        @error('name')
            <span style="color:red">{{ $message }}</span>
        @enderror
        <label class="inputName"><span>Описание</span><textarea class="input" rows="6" name="description" style="resize: vertical">{{$auto->description}}</textarea></label>
        <label class="inputName"><span>Цена</span><input value="{{$auto->price}}" class="input" type="text" name="price"></label>
        <label class="inputName"><span>Выберите иконку</span><input class="input" type="file" name="image_path" accept="image/jpeg,image/png"></label>
        <div style="display: flex; align-items: center; margin-top: 5px">
            <p style="color: rgba(143, 0, 0, 0.719); margin-right: 5px">Текущая иконка =></p>
            {!! $auto->image_path === 'assets/img/auto_notFound.jpg' ? "<p style='color:red'>Иконка отсутствует</p>" : "<img width='80px' src='" . asset('uploads/'.$auto->image_path) . "'>" !!}
        </div>
        <label class="inputName"><span>Выберите изображения для галлереи (макс. 3 картинки)</span><input class="input" multiple type="file" name="imagesForGallery[]" accept="image/jpeg,image/png"></label>
        <div style="display: flex; align-items: center; margin-top: 5px">
            <p style="color: rgba(143, 0, 0, 0.719); margin-right: 5px">Текущая галлерея =></p>
            {!! isset($autoImages->image_path_1) ? "<img width='80px' src='" . asset("uploads/".$autoImages->image_path_1)."'>" : "<p style='color:red'>Галлерея пуста</p>" !!}
            {!! isset($autoImages->image_path_2) ? "<p class='separator'>+</p> <img width='80px' src='" . asset("uploads/".$autoImages->image_path_2)."'>" : null !!}
            {!! isset($autoImages->image_path_3) ? "<p class='separator'>+</p> <img width='80px' src='" . asset("uploads/".$autoImages->image_path_3)."'>" : null !!}
        </div>
        <button type="submit" class="buttonAdd">Изменить запись</button>
    </form>
@endsection
