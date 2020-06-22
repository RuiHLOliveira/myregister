@extends('layouts.app')

{{-- DEFINES TITLE --}}
@section('title', $title)

{{-- DEFINES SIDE TITLE BUTTONS --}}
@section('titleButtons')

{{-- DEFINES SUBTITLE --}}
@section('subtitle', $subtitle)
    @if($title === 'Inbox')
        <a class="btn btn-sm btn-primary" href="{{ route('tasks.create')}}">New</a>
    @endif
@endsection

{{-- DEFINES PAGE CONTENT --}}
@section('content')
    
    @if (session('error'))
        <div class="row">
            <div class="col">
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            </div>
        </div>
    @endif

    @forelse ($tasks as $task)
        <div class="row" style="margin-bottom: 20px;">
            <div class="col">
                <div class="cardModel">
                    {{-- TASK NAME --}}
                    <div class="font15em font-weight-light">
                        {{ $task->name }}
                    </div>

                    {{-- BADGES COMPLETED AND DUE DATE --}}
                    <div>
                        @if ($task->situation != null)
                            <span class="badge badge-info">{{ $task->situation->situation }}</span>
                        @endif
                        @if ($task->situation_id == 1)
                            <span class="badge badge-primary">Due in: {{ $task->getReadableDate() }}</span>
                        @endif
                        @if($task->completed)
                            <span class="badge badge-success">Task Completed!</span>
                        @endif
                    </div>

                    {{-- PROJECT --}}
                    @if ($task->project_id != null)
                        <label for="" class="taskProjectFont">Project</label>
                        <div class="">{{ $task->project->name }}</div>
                    @endif

                    {{-- DESCRIPTION --}}
                    <label for="" class="taskProjectFont">Description</label>
                    <div class="mb-3 font-italic whiteSpacePreWrap">{{ $task->description }}</div>

                    <div>
                        <a class="btn btn-outline-success btn-sm" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                        <form class="d-inline" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Del</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        There isn't any tasks
    @endforelse
</div>
@endsection