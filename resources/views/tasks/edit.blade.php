@extends('layouts.layout')

@section('tittle', 'Edit' .  $task->name)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                        <h3 class="mx-auto">Edit Task</h3>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tasks.update', $task) }}">
                            @csrf

                            @method('put')

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
        
                                <div class="col-md-6">
                                    <input id="Editname" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $task->name }}" required autofocus>
        
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
        
                                <div class="col-md-6">
                                    <input id="EditDescription" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ $task->description }}" autofocus>
        
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Priority') }}</label>
        
                                <div class="col-md-6">
                                    <select class="form-control" id="Editpriority" name="priority" autofocus>
                                        <option value="low" {{ ($task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ ($task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ ($task->priority) == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <label for="expire_date" class="col-md-4 col-form-label text-md-right">{{ __('Expire date') }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group" id="datePicker">
                                        <input type="date" class="form-control" name="expire_date" id="EditExpireDate" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="{{ date('Y-m-d', strtotime($task->expire_date)) }}" required autofocus>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="aprox_duration" class="col-md-4 col-form-label text-md-right">{{ __('Approximate duration') }}</label>
        
                                <div class="col-md-6">
                                    <div class="input-group" id="TimePicker">
                                        <input type="time" class="form-control" name="aprox_duration" id="EditAproxDuration" value="{{ $task->aprox_duration }}" autofocus>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('Etate') }}</label>
        
                                <div class="col-md-6">
                                    <select class="form-control" id="Editstate" name="state" autofocus>
                                        <option value="active" {{ ($task->state) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="done" {{ ($task->state) == 'done' ? 'selected' : '' }}>Done</option>
                                        <option value="wip" {{ ($task->state) == 'wip' ? 'selected' : '' }}>WIP</option>
                                        <option value="postponed" {{ ($task->state) == 'postponed' ? 'selected' : '' }}>Postponed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('lists.show', $task->tdlist_id) }}" type="button" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-success">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection