<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1480, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if (($user = Auth::user()) !== null)
        {!!"<meta name='user' content='$user->id,$user->role_id'>" !!}
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page')</title>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
</head>
<body>
    @if(Route::current()->getName() === 'admin.album' || Route::current()->getName() === 'admin.comment')
        <div class="darkScreenHidden"></div>
    @endif
    <header>
        <div class="flex-block" style="width: 100%">
            <div class="flex-block">
                <a class="mainLink" href="{{route('album.index')}}">Fake Music</a>
                <ul class="nav">
                    <li><a href="{{Auth::check() ? route('album.create') : route('user.login', ['redirect' => 'add_album'])}}">Добавить альбом</a></li>
                    @admin
                        <li><a href="{{route('admin.index')}}">Панель администратора</a></li>
                    @endadmin
                </ul>
            </div>

            @yield('auth')
        </div>
    </header>
    <section class="container">

        @if(Route::current()->getName() === 'album.index')
            <div class="flex-block">
                <h2 class="currentPage">@yield('title')</h2>
                <input type="text" class="album-search" placeholder="Поиск 🔍" oninput="getAlbums(this)">
            </div>
        @else
            <h2 class="currentPage">@yield('title')</h2>
        @endif

            @yield('content')
    </section>
    <script src="{{asset('assets/js/main.js')}}" defer></script>
    <script src="{{asset('assets/js/ajax.js')}}" defer></script>
</body>
</html>
