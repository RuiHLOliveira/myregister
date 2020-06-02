@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif

    You are logged in!
</div>
@endsection
