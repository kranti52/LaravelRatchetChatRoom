<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $redirectTo='';
    protected $linkRequestView='start';
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    
    /**
    *Post Email over riding for manual processing
    *
    *
    */
    public function postEmail(Request $request)
    {
        $this->validateWithBag('forgot_password',$request, ['reset_email' => 'required|email']);
        $email=array('email'=>$request->get('reset_email'));
        $request->replace($email);
        $broker = $this->getBroker();
        $response = \Password::broker($broker)->sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });
        switch ($response) {
            case \Password::RESET_LINK_SENT:
                return $this->getSendResetLinkEmailSuccessResponse($response);

            default:
                return $this->getSendResetLinkEmailFailureResponse($response);
        }
    }
}
