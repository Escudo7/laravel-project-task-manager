<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <style>
        .header-h1 {
            position: relative;
            margin-bottom: .5rem;
            text-align: center;
        }

        .header-h1 h1 {
            margin-bottom: 0;
            font-size: 1.7rem;
            padding: 1rem 1.5rem;
        }

        .big-text {
            font-size: 1.3rem;
        }
        .botton-color {
            background-color: #6596ad;
        }
    </style>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('start') }}">Task Manager</a>
        <div class="navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('start') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('tasks.index') }}">{{ __('Tasks') }}</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/lang/en">En</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/lang/ru">Ru</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item active">
                     <a class="nav-link" href="{{ route('login') }}">{{ __('Log in') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registration') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('logout') }}" data-method="POST">
                        {{ __('Log out') }}
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('users.show', Auth::user()->id) }}">
                        {{ Auth::user()->name }} 
                    </a>
                </li>
                @endguest
            </ul>
        </div>
    </nav>

    @if(isset($message))
        @if($message['success'])
        <div class="alert alert-success" role="alert">
            {{ $message['success'] }}
        </div>
        @endif
        @if($message['warning'])
        <div class="alert alert-warning" role="alert">
            {{ $message['warning'] }}
        </div>
        @endif
        @if($message['error'])
        <div class="alert alert-danger" role="alert">
            {{ $message['error'] }}
        </div>
        @endif
    @endif

    <div class="header-h1 text-center bg-secondary text-white text-uppercase">
        <h1 class="font-weight-bold">
            @yield('header')
        </h1>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
