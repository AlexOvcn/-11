@extends('master')
@extends('header.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <form action="{{route('auth.register')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="inputName">
            <span>*Логин:</span>
            <input type="text" class="input" name="name" value="{{old('name')}}">
            @error('name')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <label class="inputName">
            <span>*Почта:</span>
            <input type="text" class="input" name="email" value="{{old('email')}}">
            @error('email')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <label class="inputName">
            <span>*Пароль:</span>
            <input type="password" class="input" name="password" value="{{old('password')}}">
            {{$errors->login->first('email')}}
            @error('password')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <label class="inputName">
            <span>*Повторите пароль:</span>
            <input type="password" class="input" name="confirm_password" value="{{old('confirm_password')}}">
            @error('confirm_password')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <label class="inputName">
            <span>Выберите аватар профиля:</span>
            <input type="file" class="input" name="avatar" accept="image/jpeg,image/png" >
            @error('avatar')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <button type="submit" class="buttonAdd">Регистрация</button>
    </form>
@endsection

