<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    public function index()
    {
    	return view('main')->with('users',User::all());
    	//return view('main');
    }

    public function edit($id)
    {
    	//
    }

    public function update($request,$id)
    {
    	//
    }

    public function destroy($id)
    {
    	//
    }
}
