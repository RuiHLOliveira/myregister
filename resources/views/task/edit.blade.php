@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <form action="{{route('tasks.update', $task->id)}}" method="POST" class="form-group">
        @csrf
        @method('put')


        @if($task->completed)
            <div class="row">
                <div class="col">
                    <span class="badge badge-success">Task Completed!</span>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" value="{{ $task->name }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="duedate">Due Date</label>
                <input class="form-control" type="date" id="duedate" name="duedate" value="{{ $task->getDate() }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="description">Description</label>
                <textarea rows="6" class="form-control" type="text" name="description">{{ $task->description }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <button class="mb-3 btn btn-secondary btn-responsive" type="button" onclick="openProjectForm()" >Put in Project...</button>
            </div>
        </div>

        <div class="hidden row" id="projectFormRow">
            <div class="col">
                <div class="grayBox">
                    <label for="project">Projects</label>
                    <input type="hidden" name="considerProjectForm" id="considerProjectForm" value='0'>
                    <select class="form-control" name="project" id="project">
                        <option disabled selected value="">--</option>

                        @foreach ($projects ?? [] as $project)
                            @if ( $project->id == $task->project_id )
                                <option selected value="{{ $project->id }}">{{ $project->name}}</option>
                            @else
                                <option value="{{ $project->id }}">{{ $project->name}}</option>
                            @endif
                        @endforeach

                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <a class="mb-3 btn btn-danger btn-responsive" href="{{ route('tasks.index')}}">back</a>
                <button class="mb-3 btn btn-success btn-responsive" onclick="onSubmitLogic()" type="submit">Just Save</button>
            {{-- </div>
        </div>

        <div class="row">
            <div class="col"> --}}
            <br>
            <label for="targetSituation">Or Send To</label><br>
            <input type='hidden' name='targetSituation' id='targetSituation'>
                <button class="mb-3 btn btn-info btn-responsive" type="submit" onclick="setTargetSituation(event,'1')" >Tickler</button>
                <button class="mb-3 btn btn-info btn-responsive" type="submit" onclick="setTargetSituation(event,'2')" >Waiting For</button>
                <button class="mb-3 btn btn-info btn-responsive" type="submit" onclick="setTargetSituation(event,'3')" >Recurring</button>
                <button class="mb-3 btn btn-info btn-responsive" type="submit" onclick="setTargetSituation(event,'4')" >Next</button>
                <button class="mb-3 btn btn-info btn-responsive" type="submit" onclick="setTargetSituation(event,'5')" >Read List</button>
                <button class="mb-3 btn btn-info btn-responsive" type="submit" onclick="setTargetSituation(event,'6')" >Someday/Maybe</button>
            </div>
        </div>
    </form>

    <div class="row  mt-5">
        <div class="col">
            <form action="{{ route('tasks.taskToProject', $task->id) }}" method="POST">
                @csrf
                <button class="mb-3 btn btn-default btn-responsive" type="submit">Transform in Project</button>
                @if(!$task->completed)
                    <a class="mb-3 btn btn-success btn-responsive" href="{{ route('tasks.completeTask', $task->id) }}">Complete Task</a>
                @endif
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
