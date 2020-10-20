<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tdlist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TdlistController extends Controller
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
        // load the create form (app/views/lists/create.blade.php)
        return view('lists.create');
    }
    
    /**
        * Store a newly created resource in storage.
        *
        * @return Response
        */
    public function store(Request $request)
    {
        // validate
        $rules = array(
            'name' => 'required',
            'description' => 'required|max:255'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->route('lists/create')
                ->withErrors($validator);
        } else {
            // store
            $list = new Tdlist();
            $list->name = $request->input('name');
            $list->description = $request->input('description');
            $list->save();

            // redirect
            return redirect()->route('lists.show', $list->id)->with('success', 'List Saved!');
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
        // get the list
        $list = Tdlist::find($id);

        $tasks = Task::where('tdlist_id', $id)->orderBy('expire_date', 'asc')->get();

        // show list view
        return view('lists.show', compact('list', 'tasks'));
    }

    /**
        * Show the form for editing the specified resource.
        *
        * @param  Request  $request
        * @return Response
        */
    public function edit($id)
    {
        // get the list
        $list = Tdlist::find($id);

        // show the edit form and pass the list
        return view('lists.edit', compact('list'));
    }

    /**
        * Update the specified resource in storage.
        *
        * @param  Request  $request
        * @return Response
        */
    public function update(Request $request, $id)
    {
        $list = Tdlist::find($id);
        // validate
        $rules = array(
            'name' => 'required',
            'description' => 'required|max:255'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->route('lists/' . $id . '/edit')
                ->withErrors($validator);
        } else {
            // store
            $list->name = $request->input('name');
            $list->description = $request->input('description');
            $list->save();

            // redirect
            return redirect()->route('lists.show', $list->id)->with('success', 'List updated!');
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
        Task::where('tdlist_id', $id)->get()->each->delete();
        Tdlist::find($id)->delete();

        // redirect
        return redirect()->route('dashboard')->with('success', 'List deleted!');
    }
}
