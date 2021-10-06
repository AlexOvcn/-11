<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page')</title>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
</head>
<body>
    <header>
        <div class="flex-block">
            <a class="mainLink {{($page === 'Все записи автомобилей') ? 'mainLinkActive' : null}}" href="{{route('cars.index')}}">Все машинки</a>
            <ul class="nav">
                <li><a href="{{route('admin.index')}}">Консоль администратора</a></li>
            </ul>
        </div>

        @yield('auth')
    </header>

    <section>
        <div class="container">
            <h2 class="currentPage">@yield('title')</h2>
            @yield('content')
        </div>
    </section>
    <script src="{{asset('assets/js/admin_selectUser_ajax.js')}}"></script>
</body>
</html>
