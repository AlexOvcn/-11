@extends('master')
@extends('user.index')

@section('page', $page)
@section('title', $page)

@section('content')
    <form action="{{route('user.login')}}" method="POST">
        @csrf

        <label class="inputName">
            <span>Почта:</span>
            <input type="text" class="input" name="email" value="{{old('email')}}">
            @error('name')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <label class="inputName">
            <span>Пароль:</span>
            <input type="password" class="input" name="password" value="{{old('password')}}">
            @error('password')
                <span style="color:red">{{ $message }}</span>
            @enderror
        </label>
        <button type="submit" class="btn btn-addBig" style="margin-top: 30px">Авторизация</button>

        @error('loginFail')
            <span style="color:red; margin-left: 20px">{{ $message }}</span>
        @enderror
    </form>
    @if (session()->get('info') === 'banned')
        <hr class="separatorLogin">
        <p class="bannedUserInfoTitle">Возможные причины блокировки</p>
        <ul class="bannedUserInfo">
            <li>Вызывающий комментарий или аватар пользователя</li>
            <li>Странное поведение пользователя на сайте</li>
            <li>Другие причины</li>
        </ul>
    @endif

    @if ($redirect = request()->get('redirect'))
        @if ($redirect = 'add_album')
            <p class="redirect">Чтобы создать альбом, нужно авторизоваться!</p>
        @endif
    @endif
@endsection
