<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
    	return view('main')->with('users',User::paginate(10));
    	//return view('main')->with('users',User::all);
    }
	
	public function create()
    {
    	return view('user.create');
    }

    public function store()
    {
    	$rules=[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ];

    	$validator=Validator::make(Input::all(), $rules);
    	if($validator->fails()){
    		return Redirect::to('users/create')->withErrors($validator)->withInput();
    	}else{
    		$user=new User;
    		$user->name=Input::get('name');
    		$user->email=Input::get('email');
    		$user->created_at=date("Y-m-d H:i:s");
    		$user->updated_at=date("Y-m-d H:i:s");
    		$user->password=bcrypt(Input::get('password'));
    		
    		$save=$user->save();
    		if(!$save){
    			Session::flash('message', ['Failed to save user','danger']);
    		}else{
    			Session::flash('message', ['Successfully save user','success']);
    		}
            return Redirect::to('users');
    	}
    }

    public function edit(Request $request,$id)
    {
    	//$request->flash();
    	return view('user.edit')->with('user',User::find($id));
    }

    public function update(Request $request,$id)
    {
    	//DB::enableQueryLog();
    	$u = DB::table('users')->where('id', $id)->where('password', Input::get('password'))->first();
    	//dd(DB::getQueryLog());
    	$edit=(count($u)>0?False:True);
    	$rules=[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ];
        if(!$edit){
        	unset($rules['password']);
        }
    	$validator=Validator::make(Input::all(), $rules);
    	if($validator->fails()){
    		return Redirect::to('users/'.$id.'/edit')->withErrors($validator)->withInput();
    	}else{
    		$user=User::find($id);
    		$user->name=Input::get('name');
    		$user->email=Input::get('email');
    		$user->updated_at=date("Y-m-d H:i:s");
    		if($edit)
    			$user->password=bcrypt(Input::get('password'));
    		
    		$save=$user->save();
    		if(!$save){
    			Session::flash('message', ['Failed to update user id: '.$id,'danger']);
    		}else{
    			Session::flash('message', ['Successfully updated user id: '.$id,'success']);
    		}
            return Redirect::to('users');
    	}
    }

    public function destroy($id)
    {
    	$user = User::find($id);
        $del=$user->delete();
        if($del){
			Session::flash('message', ['Successfully deleted the user id: '.$id,'success']);
        }else{
        	Session::flash('message', ['Failed to deleted the user id: '.$id,'danger']);
        }
        return Redirect::to('users');
    }
}
