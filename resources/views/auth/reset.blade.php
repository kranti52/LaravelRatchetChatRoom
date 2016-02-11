@extends('layout')

@section('title','Reset Password')

@section('sidebar')

@endsection

@section('content')
<div id='reset_div' style="background-image:url(img/PasswordRetrieve.png);">
    <div >
        <form method="POST" action="{{action('Auth\PasswordController@postReset')}}">
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">
        
            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div>
                Email
                <input type="email" name="email" value="{{ old('name') }}">
            </div>
        
            <div>
                Password
                <input type="password" name="password">
            </div>
        
            <div>
                Confirm Password
                <input type="password" name="password_confirmation">
            </div>
        
            <div>
                <button type="submit">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
@endsection