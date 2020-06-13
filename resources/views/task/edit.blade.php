@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <form action="{{route('tasks.update', $task->id)}}" method="POST" class="form-group">
        @csrf
        @method('put')

        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" value="{{ $task->name }}" required>
            </div>
        </div>

        {{-- <div class="row">
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
        </div> --}}

        <div class="row">
            <div class="col">
                <label for="duedate">Due Date</label>
                <input class="form-control" type="date" name="duedate" value="{{ $task->getDate() }}">
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
                <button class="btn btn-success" type="submit">Just Save</button>
            </div>
        </div>

        <div class="row">
            <div class="col">
            <label for="targetSituation">Or Send To</label><br>
            <input type='hidden' name='targetSituation' id='targetSituation'>
            
            <button class="btn btn-default" type="submit" onclick="setTargetSituation('1')" >Tickler</button>
            <button class="btn btn-default" type="submit" onclick="setTargetSituation('2')" >Waiting For</button>
            <button class="btn btn-default" type="submit" onclick="setTargetSituation('3')" >Recurring</button>
            <button class="btn btn-default" type="submit" onclick="setTargetSituation('4')" >Next</button>
            <button class="btn btn-default" type="submit" onclick="setTargetSituation('5')" >Read List</button>
            <button class="btn btn-default" type="submit" onclick="setTargetSituation('6')" >Someday/Maybe</button>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <button class="btn btn-success" type="submit" onclick="setTargetSituation('7')" >Project</button>
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

    </form>
</div>
@endsection
