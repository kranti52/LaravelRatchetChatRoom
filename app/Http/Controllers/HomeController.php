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
        //return var_dump(\Auth::user());
        if (!\Auth::check())
        {
            return \Redirect::action('GuestController@home');
        }
        
        /* Redis Testing*/
        //$redis=new Predis\Client();
        // $users=\App\User::where('logged_in','=','1')->get();
        // $redis = \Redis::connection();
        // $host = $redis->getConnection()->getParameters()->host;
        // $port = $redis->getConnection()->getParameters()->port;
        // $fp = @fsockopen($host, $port);
        // \Redis::set('users', $users);

        // $users = \Redis::get('users');
        // return var_dump($users);
        // if ( ! $fp) die('Redis server not responding at *' . $host . ':' . $port . '*');
        // return view('home',compact('users'));
        // return $name;
        
        /* Redis Testing done*/
        
        //\Event::fire(\App\Events\SocketEvent::EVENT, array('random'));
        //event(new \App\Events\SocketEvent());
        //\Event::fire(new \App\Events\SocketEvent());
        $users=\App\User::where('logged_in','=','1')->get();
        $chatPort = \Request::input("p");
		$chatPort = $chatPort ?: 8081;
        //$user=\App\User::find($users)->toarray();
        return view('home',compact('chatPort'));
    }
}
