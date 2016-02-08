<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request as rqst;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
    protected $redirectPath = '/dashboard';
    protected $loginPath = '/';
    protected $redirectAfterLogout='/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'logout']);
    }
    /**
     * Register a new user or we can say sign up
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function register(RegisterRequest $request)
    {
        $rqst=new rqst();
        $data=$request->all();
        $data['password']=bcrypt($data['password']);
        $users=User::Create($data);
        //return var_dump($users);
        if(\Auth::attempt(['username'=>$data['username'],'password'=>$request->get('password')]))
        {
            User::where('id','=',\Auth::user()->id)->update(array('logged_in'=>'1'));
            \Flash::message('You are successfully registered.');
            return \Redirect::action('HomeController@dashboard');//,compact('users'));
        }
        return 'not working';
        
       
    }
    
    /**
     * For login of Users
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function login(LoginRequest $request)
    {

        /*if($request->has('remember') && $request->get('remember')=='on')
        {
            if(\Auth::attempt(['username'=>$request->get('username'),'password'=>$request->get('password')]))
            {
                User::where('id','=',\Auth::user()->id)->update(array('logged_in'=>'1'));//->update(array('logged_in'=>1));
                \Flash::message('You are successfully login.');
                return \Redirect::action('HomeController@dashboard');//,compact('users'));
            }
        }else {*/
            if(\Auth::attempt(['username'=>$request->get('username'),'password'=>$request->get('password')]))
            {
                User::where('id','=',\Auth::user()->id)->update(array('logged_in'=>'1'));//->update(array('logged_in'=>1));
                \Flash::message('You are successfully login.');
                return \Redirect::action('HomeController@dashboard');//,compact('users'));
            }
            \Flash::error('Username and Password doesn\'t match');
            return \Redirect::back();
        //}
        
        
    }
    
    /**
     * For logout of Users
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function logout()
    {
        
        User::where('id','=',\Auth::user()->id)->update(array('logged_in'=>'0'));
        \Auth::logout();
        \Flash::message('You are successfully logged out.');
        return \Redirect::action('GuestController@home');
        
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
