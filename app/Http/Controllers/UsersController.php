<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    public function create() {
        return view('users.create');
    }

    public function store(Request $request) {
        return view('users.index');
    }

    public function show($id) {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }
    
    public function edit($id) {
        $edit = User::find($id);
        return view('users.edit', compact('edit'));
    }

    public function update(Request $request, $id) {
        return view('users.index');
    }

    public function destroy($id) {
        return back();
    }
}
