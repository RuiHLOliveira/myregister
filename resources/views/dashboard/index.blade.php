@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('titleButtons')
@endsection

@section('content')
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif
    You are logged in!
</div>
@endsection
