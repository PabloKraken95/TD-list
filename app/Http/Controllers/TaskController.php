<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
    public function index()
    {
        //
    }
    
    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create()
    {
        //
    }
    
    /**
        * Store a newly created resource in storage.
        *
        * @return Response
        */
    public function store(Request $request, $id)
    {
        // validate
        $rules = array(
            'name' => 'required|max:50',
            'description' => 'max:255',
            'expire_date' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->route('lists/' . $id)
                ->withErrors($validator);
        } else {
            // store
            $task = new Task();
            $task->name = $request->input('name');
            $task->tdlist_id = $id;
            $task->description = $request->input('description');
            $task->aprox_duration = $request->input('aprox_duration');
            $task->priority = $request->input('priority');
            $task->expire_date = $request->input('expire_date');
            $task->save();

            // redirect
            return redirect()->route('lists.show', $id)->with('success', 'Task saved!');
        }
    }

    /**
        * Display the specified resource.
        *
        * @param  Request  $request
        * @return Response
        */
    public function show($id)
    {
        //
    }
    
    /**
        * Display the specified resource.
        *
        * @param  Request  $request
        * @return Response
        */
    public function sortBy($list_id, $state, $priority)
    {
        // get the sorted tasks
        if($state != 'empty' && $priority != 'empty') {
            $tasks = Task::where('tdlist_id', $list_id)->where('state', $state)->where('priority', $priority)->orderBy('expire_date', 'asc')->get();
        }
        elseif($state=='empty' && $priority=='empty'){
            $tasks = Task::where('tdlist_id', $list_id)->orderBy('expire_date', 'asc')->get();
        }
        elseif($state=='empty'){
            $tasks = Task::where('tdlist_id', $list_id)->where('priority', $priority)->orderBy('expire_date', 'asc')->get();
        }
        elseif($priority=='empty'){
            $tasks = Task::where('tdlist_id', $list_id)->where('state', $state)->orderBy('expire_date', 'asc')->get();
        }
        else{
            return 'Error';
        }

        // // return sorted task
        return $tasks;
    }   

    /**
        * Show the form for editing the specified resource.
        *
        * @param  Request  $request
        * @return Response
        */
    public function edit($id)
    {
        // get the task
        $task = Task::find($id);

        // show the edit form and pass the task
        return view('tasks.edit', compact('task'));
    }

    /**
        * Update the specified resource in storage.
        *
        * @param  Request  $request
        * @return Response
        */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        // validate
        $rules = array(
            'name' => 'required',
            'description' => 'required|max:255'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->route('lists/' . $id)
                ->withErrors($validator);
        } else {
            // store
            $task->name = $request->input('name');
            $task->description = $request->input('description');
            $task->aprox_duration = $request->input('aprox_duration');
            $task->priority = $request->input('priority');
            $task->expire_date = $request->input('expire_date');
            $task->state = $request->input('state');
            $task->save();

            // redirect
            return redirect()->route('lists.show', $task->tdlist_id)->with('success', 'Task updated!');
        }
    }
        
    /**
        * Remove the specified resource from storage.
        *
        * @param  Request  $request
        * @return Response
        */
    public function destroy($id)
    {
        $task = Task::find($id);
        $list_id = $task->tdlist_id;
        Task::find($id)->delete();

        // redirect
        return redirect()->route('lists.show', $list_id)->with('success', 'Task deleted!');
    }
}
