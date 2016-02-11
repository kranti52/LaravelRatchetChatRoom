<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $errorBag='register';
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:255|min:6',
            'email'=>'required|email|unique:users,email,email',
            'username'=>'required|unique:users,username,username',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required_with:password',
        ];
    }
}
