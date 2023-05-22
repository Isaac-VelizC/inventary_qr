<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->admin) {
            $areas = Area::all();
            return view('home')->with('areas', $areas);
        }
        return view('welcome');
    }
}
