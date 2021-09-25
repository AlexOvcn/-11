@extends('master')

@section('page', $page)
@section('title', null)

@section('content')
    <h1>Модель машины: {{$auto->name}}</h1>
    <h3>ID номер: {{$auto->id}}</h3>
    <h3>Иконка: </h3>
    <img width="400px" src="{{$auto->image_path === 'assets/img/auto_notFound.jpg' ? asset($auto->image_path) : asset('uploads/'.$auto->image_path)}}">
    <h3>Краткое описание: {{$auto->description === null ? 'Описание отсутствует' : $auto->description}}</h3>
    <h3>Цена: {{$auto->price === null ? 'Бесценна' : $auto->price}}</h3>
    <h3>Галлерея: </h3>
    {!! isset($autoImages->image_path_1) ? "<img width='300px' src='" . asset('uploads/'.$autoImages->image_path_1) . "'>" : "<p style='color:red'>Галлерея пуста</p>" !!}
    {!! isset($autoImages->image_path_2) ? "<img width='300px' src='" . asset('uploads/'.$autoImages->image_path_2) . "'>" : null !!}
    {!! isset($autoImages->image_path_3) ? "<img width='300px' src='" . asset('uploads/'.$autoImages->image_path_3) . "'>" : null !!}
@endsection
