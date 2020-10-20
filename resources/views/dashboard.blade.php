@extends('layouts.layout')

@section('tittle', 'Dashboard')
    
@section('content')
    <div class="container row col-11 mx-auto mt-5">
        @foreach ($lists as $list)
        <div class="card col-xl-3 col-lg-4 col-md-5 mx-3 my-3 justify-content-around">
            <div class="card-body">
                <h5 class="card-title"><a class="card-title" href="{{ route('lists.show', $list->id) }}">{{ $list->name }}</a></h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $list->description }}</h6>
                <ul class="list-group">
                    @foreach ($list->tasks as $task)
                        <li class="list-group-item">{{ $task->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
    </div>
@endsection