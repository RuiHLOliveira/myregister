@extends('layouts.appnoside')

@section('content')
    <h1>Welcome to {{ config('app.name') }}!</h1>
    @guest
    {{-- login e register --}}
        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
            <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
        @endif
    @else
        {{-- menus e logout --}}
        <a class="btn btn-primary" href="#homeSubmenu" data-toggle="collapse" class="dropdown-toggle">
            Hey, {{ Auth::user()->name }}!
        </a>
        <form id="" action="{{ route('logout') }}" method="POST">
            @csrf
            <input class="buttonAsLink" type="submit" value="{{ __('Logout') }}">
        </form>
        <a class="btn btn-primary" href="{{ route('dashboardIndex') }}">Access application</a>
    @endguest
</div>
@endsection
