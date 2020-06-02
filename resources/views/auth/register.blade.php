@extends('layouts.appnoside')

@section('content')
<style>
    .registerContainer {
        display: flex;
        justify-content: center;
        padding-top: 155px;
    }
    .registerContainer form{
        flex-basis: 450px;
        flex-grow: 0;
        flex-shrink: 1;
    }
    .bodyclass {
        background-color: #2d3a4b;
        color: #eeeeee;
    }
    .registerContainer input,
    .registerContainer input:focus {
        color: #eeeeee;
        background-color: #283443;
        border: 1px solid #3e4956;
        box-shadow: none;
    }
</style>
<div class="registerContainer backgroundcolor">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- linha 1 --}}
        <div class="form-group row">
            <div class="col-md-12 text-center">
                <h4 class="font-weight-bold">Register Form</h4>
            </div>
        </div>

        {{-- linha 2 --}}
        <div class="form-group row">
            <div class="col-md-12">
                <input id="name" placeholder="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- linha 3 --}}
        <div class="form-group row">
            <div class="col-md-12">
                <input id="email" placeholder="e-mail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- linha 4 --}}
        <div class="form-group row">
            <div class="col-md-12">
                <input id="password" placeholder="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <input id="password-confirm" placeholder="password confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        {{-- linha 5 --}}
        <div class="form-group row">
            <div class="col-md-6">
                <button type="submit" class="btn btn-default form-control">
                    {{ __('Register') }}
                </button>
            </div>
            <div class="col-md-6">
                <a class="btn btn-border form-control" href="{{ route('login') }}">Back to login</a>
            </div>
        </div>

    </form>
</div>
@endsection
