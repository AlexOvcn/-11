<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page')</title>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
</head>
<body>
    <header>
        <div class="container">
            <a class="mainLink {{($page === 'Все записи автомобилей') ? 'mainLinkActive' : null}}" href="{{route('cars.index')}}">Все машинки</a>
        </div>
    </header>

    <section>
        <div class="container">
            <h2 class="currentPage">@yield('title')</h2>
            @yield('content')
        </div>
    </section>
</body>
</html>
