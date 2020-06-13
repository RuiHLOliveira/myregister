@extends('layouts.app')

@section('title', 'New Situation')

@section('content')

    <form action="{{route('situations.store')}}" method="POST" class="form-group">
        @csrf

        <div class="row">
            <div class="col">
                <label for="situation">Situation</label>
                <input class="form-control" type="text" name="situation">
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <a class="btn btn-danger" href="{{ route('situations.index') }}">back</a>
                <button class="btn btn-success" type="submit">Add</button>
            </div>
        </div>
    </form>
</div>
@endsection
