@extends('layouts.app')

{{-- DEFINES TITLE --}}
@section('title', 'Tasks')

{{-- DEFINES SIDE TITLE BUTTONS --}}
@section('titleButtons')
<a class="btn btn-sm btn-primary" href="{{ route('tasks.create')}}">New</a>
@endsection

{{-- DEFINES PAGE CONTENT --}}
@section('content')
    <table class="table">
        <tbody>
            
            @forelse ($tasks as $task)
                <tr>
                    <td>
                        <div class="font15em">{{ $task->id }} - {{ $task->name }}</div>
                        <div class="font-italic font-weight-light"><pre>{{ $task->description }}</pre></div>
                        <div class="">
                            @if ($task->situation != null)
                                {{ $task->situation->situation }}
                            @endif
                        </div>
                        <div>
                            <a class="btn btn-outline-success btn-sm" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                            <form class="d-inline" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Del</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                There isn't any tasks
            @endforelse
            
        </tbody>
    </table>
</div>
@endsection