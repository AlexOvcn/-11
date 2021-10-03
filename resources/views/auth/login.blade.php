@extends('master')
@extends('header.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <form action="{{route('auth.login')}}" method="POST"">
        @csrf

        <label class="inputName">
            <span>Логин:</span>
            <input type="text" class="input" name="name">
            @error('name')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <label class="inputName">
            <span>Пароль:</span>
            <input type="password" class="input" name="password">
            @error('password')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <button type="submit" class="buttonAdd">Авторизация</button>
        @error('loginFail')
            <span style="color:red; margin-left: 20px">{{ $message }}</span>
        @enderror
    </form>
@endsection
