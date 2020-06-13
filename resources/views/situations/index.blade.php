@extends('layouts.app')

{{-- DEFINES TITLE --}}
@section('title', 'Situations')

{{-- DEFINES SIDE TITLE BUTTONS --}}
@section('titleButtons')
<a class="btn btn-sm btn-primary" href="{{ route('situations.create')}}">New</a>
@endsection

{{-- DEFINES PAGE CONTENT --}}
@section('content')
    <table class="table">
        <tbody>
            
            @forelse ($situations as $situation)
                <tr>
                    <td>
                        <div class="font15em">{{ $situation->id }} - {{ $situation->situation }}</div>
                        <div class="font-italic font-weight-light"><pre>{{ $situation->situation }}</pre></div>
                        <div>
                            <a class="btn btn-outline-success btn-sm" href="{{ route('situations.edit', $situation->id) }}">Edit</a>
                            <form class="d-inline" action="{{ route('situations.destroy', $situation->id) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Del</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                There isn't any situations
            @endforelse
            
        </tbody>
    </table>
</div>
@endsection