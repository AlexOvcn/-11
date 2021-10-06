@extends('master')
@extends('header.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <a href="{{route('cars.create')}}" class="buttonAdd" style="margin: 0">Добавить машину</a>

    @if ($auto->isEmpty())
        <h2 style="margin-top: 20px">Пока что нет ни одной записи!</h2>
    @else
        <table style="width: 100%">
            <thead style="height: 80px">
                <tr>
                    <td style="width: 8%">Модель</td>
                    <td style="width: 8%">Иконка</td>
                    <td style="width: 42%">Краткое описание</td>
                    <td style="width: 10%">Цена</td>
                    <td style="width: 32%">Действия</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($auto as $automobile)
                    <tr>
                        <td style="font-size: 17px;font-weight: 600">{{$automobile->name}}</td>
                        <td><img width="80px" src="{{$automobile->image_path === 'assets/img/auto_notFound.jpg' ? asset($automobile->image_path) : asset('uploads/'.$automobile->image_path)}}"></td>
                        <td>{{$automobile->description === null ? 'Описание отсутствует' : $automobile->description}}</td>
                        <td>{{$automobile->price === null ? 'Бесценна' : $automobile->price}}</td>
                        <td>
                            <div class="flex-block">
                                <a class="button-show" href="{{route('cars.show', $automobile->id)}}">Подробнее</a>
                                <a class="button-edit" href="{{route('cars.edit', $automobile->id)}}">Изменить</a>
                                <form action="{{route('cars.destroy', $automobile->id)}}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="button-delete">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
