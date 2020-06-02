@extends('layouts.app')

@section('title')
    New Project
@endsection

@section('content')
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="description">Description</label>
                <textarea rows="5" class="form-control" name="description" id="description"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <a class="btn btn-danger" href="{{ route('projects.index') }}">Back</a>
                <button class="btn btn-success" type="submit">Add</button>
            </div>
        </div>
    </form>
@endsection