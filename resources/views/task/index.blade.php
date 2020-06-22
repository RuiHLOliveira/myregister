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
                <div class="font15em font-weight-light">
                    {{ $task->name }}
                </div>

                @if($task->completed)
                    <div>
                        <span class="badge badge-success">Task Completed!</span>
                    </div>
                @endif
                
                @if ($task->project_id != null)
                    <div>
                        <span class="taskProjectFont">Project: {{ $task->project->name }}</span>
                    </div>
                @endif

                @if ($task->situation_id == 1)
                    <div class="mb-3">Due in: {{ $task->getReadableDate() }}</div>
                @endif
                
                <div class="mb-3 font-italic whiteSpacePreWrap boxBorderLeft">{{ $task->description }}</div>

                @if ($task->situation != null)
                    <div class="mb-3"><small class="text-muted">{{ $task->situation->situation }}</small></div>
                @endif

                <div class="mb-3">
                    <a class="btn btn-outline-success btn-sm" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                    <form class="d-inline" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Del</a>
                    </form>
                </div>

            </div>
        </div>
    @empty
        There isn't any tasks
    @endforelse
</div>
@endsection