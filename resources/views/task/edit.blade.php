@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <form action="{{route('tasks.update', $task->id)}}" method="POST" class="form-group">
        @csrf
        @method('put')

        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" value="{{ $task->name }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="situation">
                    Choose a Situation
                </label>

                <select class="form-control" name="situationSelect" id="situationSelect">
                    <option disabled selected value="">--</option>
                    @foreach ($situations ?? [] as $situation)
                    @if ( $situation->id == $task->situation_id )
                        <option selected value="{{ $situation->id }}">{{ $situation->situation}}</option>
                    @else
                        <option value="{{ $situation->id }}">{{ $situation->situation}}</option>
                    @endif
                    @endforeach
                </select>
                
                <label for="situation">
                    or create one
                </label>
                <input id="situationInput" class="form-control" type="text" name="situationInput">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="description">Description</label>
                <textarea rows="5" class="form-control" type="text" name="description">{{ $task->description }}</textarea>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <a class="btn btn-danger" href="{{ route('tasks.index')}}">back</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>

    </form>
</div>
@endsection
