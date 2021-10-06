

@section('auth')
    @if ($user= Auth::user() ?? null)
        <div class="flex-block">
            <p class="welcome">Приветствую {{$user->name}}!</p>
            <img class="userAvatar" src="{{$user->avatar === 'assets/img/hasNotAvatar.jpg' ? asset($user->avatar) : asset('uploads/'.$user->avatar)}}" >
            <a class="btn btn-logout" href="{{route('auth.logout')}}">Выйти</a>
        </div>
    @else
        <div class="flex-block">
            <p class="welcome">Приветствую, гость!</p>
            <a class="btn btn-login" href="{{route('auth.loginForm')}}">Войти</a>
            <a class="btn btn-register" href="{{route('auth.registerForm')}}">Зарегистрироваться</a>
        </div>
    @endif
@endsection
