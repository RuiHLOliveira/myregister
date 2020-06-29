@extends('layouts.app')

{{-- DEFINES TITLE --}}
@section('title', $title ?? '')

{{-- DEFINES SIDE TITLE BUTTONS --}}
@section('titleButtons')

{{-- DEFINES SUBTITLE --}}
@section('subtitle', $subtitle ?? '')
    <a class="btn btn-sm btn-primary" href="{{ route('invitations.create')}}">New</a>
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

    @forelse ($invitations as $invitation)
        <div class="row" style="margin-bottom: 20px;">
            <div class="col">
                <div class="cardModel">
                    {{-- invitation NAME --}}
                    <div class="font15em font-weight-light">
                        {{ $invitation->id }} - {{ $invitation->invitation_token }}<br>
                        {{ route('register') }}?invitation_token={{ $invitation->invitation_token }}
                    </div>

                    {{-- BADGES COMPLETED AND DUE DATE --}}
                    <div>
                        @if ($invitation->active)
                            <span class="badge badge-success">Active</span>
                        @endif
                        @if (!$invitation->active)
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </div>

                    {{-- <div>
                        <a class="btn btn-outline-success btn-sm" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                        <form class="d-inline" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Del</a>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    @empty
        There isn't any invitation
    @endforelse
</div>
@endsection