@extends('layouts.layout')

{{-- @section('tittle', $list->name) --}}

@section('extra_styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endsection

@section('extra_items')
        <a class="btn btn-info mx-2" href="{{ route('lists.edit', $list->id) }}">Edit this list</a>
        <button type="button" name="{{ $list->name }}" value="{{ $list->id }}" id="delListButton" class="btn btn-danger mx-2" data-toggle="modal" data-target="#delListModal">Delete this list</button>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="list-tittle mb-5">
            <h1>{{ $list->name }}</h1>
            <h4 class="text-muted">{{ $list->description }}</h4>
        </div>

        <div id="tableContent">
            <table class="table text-center" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Approximate duration</th>
                        <th scope="col">Priority</th>
                        <th scope="col">State</th>
                        <th scope="col">Expire date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            {{-- <th scope="row"></th> --}}
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->aprox_duration }}</td>
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->state }}</td>
                            <td>{{ date('d-m-Y', strtotime($task->expire_date)) }}</td>
                            <td>
                                <a type="button" class="btn btn-info my-lg-0 my-1" href="{{ route('tasks.edit', $task->id) }}"><i class="fas fa-edit"></i></a>
                                <button type="button" name="{{ $task->name }}" value="{{ $task->id }}" class="btn btn-danger delTaskButton my-lg-0 my-1" data-toggle="modal" data-target="#delTaskModal"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="sort-btns">
            <!-- Button trigger Add task modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">Add Task</button>
            <!-- Split dropup button -->
            <select class="btn btn-secondary sort-by-select" id="state">
                <option value="empty">Sort by state</option>
                <option value="active">Active</option>
                <option value="done">Done</option>
                <option value="done">Wip</option>
                <option value="postponed">Postponed</option>
            </select>
            <select class="btn btn-secondary sort-by-select" id="priority">
                <option value="empty">Sort by priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
    </div>

    <!-- Add task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('tasks.store', $list) }}" id="addTaskForm">

                    @csrf

                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

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
                                <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ old('description') }}" autofocus>

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
                                <select class="form-control" id="selectPriority" name="priority" autofocus>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expire_date" class="col-md-4 col-form-label text-md-right">{{ __('Expire date') }}</label>

                            <div class="col-md-6">
                                <div class="input-group" id="datePicker">
                                    <input type="date" class="form-control" name="expire_date" id="expire_date" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="aprox_duration" class="col-md-4 col-form-label text-md-right">{{ __('Approximate duration') }}</label>

                            <div class="col-md-6">
                                <div class="input-group" id="TimePicker">
                                    <input type="time" class="form-control" name="aprox_duration" id="aprox_duration">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div class="modal fade" id="delTaskModal" tabindex="-1" role="dialog" aria-labelledby="delTaskModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="delTaskModalTitle">Delete Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to delete <span id="delTaskName"/>?</h3>
            </div>
            <form method="POST" action="{{ route('tasks.destroy', $list) }}" id="delTaskForm">
                @csrf

                @method('delete')

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="delTaskCancel" data-dismiss="modal">Close</button>
                    <button type="submit" value="" id="delTaskModalButton" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Delete List Modal -->
    <div class="modal fade" id="delListModal" tabindex="-1" role="dialog" aria-labelledby="delListModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="delListModalTitle">Delete List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to delete {{ $list->name }}?</h3>
            </div>
            <form method="POST" action="{{ route('lists.destroy', $list) }}" id="addListForm">
                @csrf

                @method('delete')

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="delListCancel" data-dismiss="modal">Close</button>
                    <button type="submit" value="" id="delListModalButton" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    {{-- <input type="hidden" name="csrf" id="csrf" value="{{ csrf_token() }}"> --}}
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $(".delTaskButton").on('click', function () {
                var task_id = $(this).val();
                var task_name = $(this).attr('name');
                $("#delTaskModalButton").val(task_id);
                $("#delTaskName").text(task_name);
            })

            $(".sort-by-select").on('change', function () {
                var state = $('select#state').val();
                var priority = $('select#priority').val();
                var list_id = $('#delListButton').val();
                $.ajax(
                {
                    type: 'GET',
                    url: '/task/'+list_id+'/sortBy/'+state+'/'+priority,
                    success: function (response) {
                        console.log(response);
                        var sortedTable = '<table class="table" id="dataTable">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th scope="col">Name</th>'+
                                    '<th scope="col">Description</th>'+
                                    '<th scope="col">Approximate duration</th>'+
                                    '<th scope="col">Priority</th>'+
                                    '<th scope="col">State</th>'+
                                    '<th scope="col">Expire date</th>'+
                                    '<th scope="col">Action</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>'+
                            '</tbody>'+
                        '</table>';
                        $("#dataTable").remove(); 
                        console.log(sortedTable);
                        $('#tableContent').append(sortedTable);
                        var task;
                        for (var i = 0; i < response.length; i++) {
                            console.log('entro al for');
                            task = response[i];
                            console.log(task);
                            $('#dataTable tbody').append('<tr><td>'+task.name+'</td>'+
                                '<td>'+task.name+'</td>'+
                                '<td>'+task.aprox_duration+'</td>'+
                                '<td>'+task.priority+'</td>'+
                                '<td>'+task.state+'</td>'+
                                '<td>pendiente</td>'+
                                '<td>'+
                                    '<a type="button" class="btn btn-info" href="/task/'+task.id+'/edit"><i class="fas fa-edit"></i></a>'+
                                    '<button type="button" name="'+task.name+'" value="'+task.id+'" class="btn btn-danger delTaskButton" data-toggle="modal" data-target="#delTaskModal"><i class="fas fa-trash-alt"></i></button>'+
                                '</td></tr>');
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            })
    </script>
@endsection
@section('extra_scripts')
@endsection