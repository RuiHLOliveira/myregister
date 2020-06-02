@extends('layouts.app')

@section('title')
    Projects
@endsection

@section('titleButtons')
    <a class="btn btn-sm btn-primary" href="{{ route('projects.create') }}">New</a>
@endsection

@section('content')

    <table class="table">
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <td>
                        <div class="font15em">
                            {{ $project->name }}
                        </div>
                        <div class="font-italic">
                            {{ $project->description }}
                        </div>
                        <div>
                            <a class="btn btn-outline-success btn-sm" href="{{ route('projects.edit', $project->id) }}">Edit</a>
                            <form class="d-inline" action="{{ route('projects.destroy', $project->id) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Del</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                There isn't any projects                
            @endforelse
        </tbody>
    </table>
    
@endsection