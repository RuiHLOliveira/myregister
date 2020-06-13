@extends('layouts.app')

@section('title', 'New Task')

@section('content')

    <form action="{{route('tasks.store')}}" method="POST" class="form-group">
        @csrf

        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" required>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col">
                <label for="description">Description</label>
                <textarea rows="5" class="form-control" type="text" name="description"></textarea>
            </div>
        </div> --}}
        
        <div class="row">
            <div class="col">
                <a class="btn btn-danger" href="{{ route('tasks.index') }}">back</a>
                <button class="btn btn-success" type="submit">Add</button>
            </div>
        </div>
    </form>
</div>
@endsection
