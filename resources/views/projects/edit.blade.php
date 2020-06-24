@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <form action="{{route('projects.update', $project->id)}}" method="POST" class="form-group">
        @csrf
        @method('put')

        @if($project->completed)
            <div class="row">
                <div class="col">
                    <span class="badge badge-success">Project Completed!</span>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" value="{{ $project->name }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="duedate">Due Date</label>
                <input class="form-control" type="date" name="duedate" value="{{ $project->getDate() }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="description">Description</label>
                <textarea rows="1" class="form-control" type="text" name="description">{{ $project->description }}</textarea>
            </div>
        </div>

        

        <div class="row">
            <div class="col">
                <a class="btn btn-danger" href="{{ route('projects.index')}}">back</a>
                <button class="btn btn-success" onclick="onSubmitLogic()" type="submit">Just Save</button>
            </div>
        </div>

    </form>

    <div class="row">
        <div class="col">
            @if(!$project->completed)
                <a href="{{ route('projects.completeProject', $project->id) }}" class="btn btn-success">Mark as completed</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <button class="btn btn-primary" onclick="showViewInsertTask()" type="button">Add a Task</button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form id="insertTaskForm" class="form-group hidden" action="{{route('tasks.store')}}" method="POST">
                @csrf

                <div class="grayBox">
                    <div class="row">
                        <div class="col">
                            <label for="name">Name</label>
                            <input class="form-control" type="hidden" name="project" value="{{$project->id}}" required>
                            <input class="form-control" type="text" name="name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success" type="submit">Add</button>
                        </div>
                    </div>

                </div>
            </form>
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
    
</div>
@endsection
