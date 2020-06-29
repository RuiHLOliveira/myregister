<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {{-- jquery and bootstrap --}}
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/886bf3cc12.js" crossorigin="anonymous"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,400;0,700;1,200;1,400&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/sidenavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/myscript.js') }}"></script>
</head>
<body>
<div class="wrapper">

    <nav id="sidebar">
        <div class="sidebar-header">

            {{-- app name --}}
            <a href="{{ url('/') }}">{{ config('app.name') }}</a>

            {{-- toggles menu --}}
            {{-- <button class="btn btn-default btn-sm mainMenuButton" onclick="toggleMenu()">menu</button> --}}
        </div>
        
        <ul id="nav-menu" class="list-unstyled components">
                
            @guest
            {{-- login e register --}}
                <li>
                    <a class="" href="{{ route('login') }}">Login</a>
                </li>
                @if (Route::has('register'))
                    <li>
                        <a class="" href="{{ route('register') }}">Register</a>
                    </li>
                @endif
            @else
            {{-- menus e logout --}}
                <li class="">
                    <a href="#homeSubmenu" data-toggle="collapse" class="dropdown-toggle">
                        Hey, {{ Auth::user()->name }}!
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <!-- simple item -->
                        <li>
                            <form id="" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input class="buttonAsLink" type="submit" value="{{ __('Logout') }}">
                            </form>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="" href="{{ route('tasks.index') }}">Inbox</a>
                </li>
                <li>
                    <a class="" href="{{ route('tasks.tickler') }}">Tickler</a>
                </li>
                <li>
                    <a class="" href="{{ route('tasks.waitingfor') }}">Waiting For</a>
                </li>
                <li>
                    <a class="" href="{{ route('tasks.recurring') }}">Recurring</a>
                </li>
                <li>
                    <a class="" href="{{ route('tasks.next') }}">Next</a>
                </li>
                <li>
                    <a class="" href="{{ route('tasks.readlist') }}">Reading List</a>
                </li>

                <li>
                    <a class="" href="{{ route('projects.index') }}">Projects</a>
                </li>
                <li>
                    <a class="" href="{{ route('situations.index') }}">Situations</a>
                </li>

                <li>
                    <a class="" href="{{ route('tasks.somedaymaybe') }}">Someday / Maybe</a>
                </li>

                <li>
                    <a class="" href="{{ route('invitations.index') }}">Invitations</a>
                </li>
                
            @endguest
            
            <!-- item dropdown -->
            {{-- <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" class="dropdown-toggle">Home</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <!-- simple item -->
                    <li>
                        <a href="#">Home 1</a>
                    </li>
                    <!-- simple item -->
                    <li>
                        <a href="#">Home 2</a>
                    </li>
                    <!-- simple item -->
                    <li>
                        <a href="#">Home 3</a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </nav>
    <main class="container pt-1">
        <h1>
            @include('layouts.menuButton')
            @yield('title')
            @yield('titleButtons')
        </h1>
        <h5><small class="text-muted">@yield('subtitle')</small></h5>
        <hr>
        @yield('content')
    </main>
</div>
</body>

</html>