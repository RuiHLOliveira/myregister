@extends('layouts.app')

@section('title', $title)

@section('content')

    <form action="{{route('invitations.store')}}" method="POST" class="form-group">
        @csrf

        <div class="row">
            <div class="col">
                <label for="invitationToken">Invitation Token - not required</label>
                <input class="form-control" type="text" name="invitationToken">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <a class="btn btn-danger" href="{{ route('invitations.index') }}">back</a>
                <button class="btn btn-success" type="submit">Add</button>
            </div>
        </div>

        @if (session('error'))
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger">
                        {{session('error')}}
                    </div>
                </div>
            </div>
        @endif

    </form>
</div>
@endsection
