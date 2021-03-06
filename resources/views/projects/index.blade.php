@extends('layouts.app')

{{-- DEFINES TITLE --}}
@section('title', $title)

{{-- DEFINES SIDE TITLE BUTTONS --}}
@section('titleButtons')

{{-- DEFINES SUBTITLE --}}
@section('subtitle', $subtitle)
    @if($title === 'Inbox')
        <a class="btn btn-sm btn-primary" href="{{ route('projects.create')}}">New</a>
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

    @forelse ($projects as $project)
        <div class="row" style="margin-bottom: 20px;">
            <div class="col">
                <div class="cardModel">
                
                    {{-- PROJECT NAME --}}
                    <div class="font15em font-weight-light">
                        {{ $project->name }}
                    </div>

                    {{-- DESCRIPTION --}}
                    <label for="" class="taskProjectFont">Description</label>
                    <div class="mb-3 font-italic whiteSpacePreWrap">{{ $project->description }}</div>

                    {{-- BADGES COMPLETED AND DUE DATE --}}
                    <div class="mb-3 font-italic">
                        <label for="" class="taskProjectFont">Tasks</label>
                        @foreach ( $project->tasks as $task)
                            <div class="ml-3">{{$task->name}}</div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <a class="btn btn-outline-success btn-sm" href="{{ route('projects.edit', $project->id) }}">Edit</a>
                        <form class="d-inline" action="{{ route('projects.destroy', $project->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Del</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @empty
        There isn't any projects
    @endforelse
</div>
@endsection