<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GuestController extends Controller
{
    //
    public function home(Request $request)
    {
        if (\Auth::check())
        {
            return \Redirect::action('HomeController@dashboard');
        }
        return view('start');
    }
    public function open()
    {
        if (!\Auth::check())
        {
            return view('start');
        }
        return \Redirect::action('HomeController@dashboard');
    }
}
