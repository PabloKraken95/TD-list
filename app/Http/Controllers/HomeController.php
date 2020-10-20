<?php

namespace App\Http\Controllers;

use App\Models\Tdlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $lists = Tdlist::all();

        return view('dashboard', compact('lists'));
    }
}
