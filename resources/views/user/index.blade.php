
@section('auth')
    @if (($user= Auth::user()) !== null)
        <div class="flex-block">
            <p class="welcome">Здравствуйте {{$user->name}}!</p>
            <img class="userAvatar" src="{{$user->avatar === null ? asset('assets/img/hasNotAvatar.jpg') : asset('uploads/'.$user->avatar)}}" >
            <a class="btn btn-logout" href="{{route('user.logout')}}">Выйти</a>
        </div>
    @else
        <div class="flex-block">
            <p class="welcome">Добро пожаловать, гость!</p>
            <a class="btn btn-login" href="{{route('user.loginForm')}}">Войти</a>
            <a class="btn btn-register" href="{{route('user.registerForm')}}">Зарегистрироваться</a>
        </div>
    @endif
@endsection
