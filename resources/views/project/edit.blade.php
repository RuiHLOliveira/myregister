@extends('layouts.app')

@section('title')
    Edit Project
@endsection

@section('content')
    <form action="{{ route('projects.update',$project->id) }}" method="POST">
        @csrf
        @method('put')

        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" value="{{ $project->name }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="description">Description</label>
            <textarea rows="5" class="form-control" name="description" id="description">{{ $project->description }}</textarea>
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