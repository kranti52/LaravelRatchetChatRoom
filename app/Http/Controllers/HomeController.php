<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
   
    public function dashboard(Request $request)
    {
        if (!\Auth::check())
        {
            return \Redirect::action('GuestController@home');
        }
        
        $users=\App\User::where('logged_in','=','1')->get();
		$chatPort = 8082;
        return view('home',compact('chatPort'));
    }
}
