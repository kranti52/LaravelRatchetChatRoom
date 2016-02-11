@extends('layout')

@section('title','Start')

@section('sidebar')

@endsection

@section('content')
@if (Session::has('flash_notification.message') and Session::get('flash_notification.level')!='danger')
   <div class="alert alert-info">{{ Session::get('flash_notification.message') }}</div>
@endif

@if (Session::has('flash_notification.level') and Session::get('flash_notification.level')=='danger')
   <p class="alert alert-danger" >{{ Session::get('flash_notification.message') }}</p>
@endif
@if($errors->any())
{{dump($errors)}}
<h4>{{$errors->first()}}</h4>
@endif

@if (count($errors->login) > 0)
<div id='errors'>
    
        <div class="alert">
            <ul>
                @foreach ($errors->login->all() as $error)
                    <li class="alert alert-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    
</div>
@endif
@if (!empty($login_error))
<div id='errors'>
        <div class="alert">
            {{$login_error}}
        </div>
</div>
@endif
<div id="login_div">
  <div class="vid-container">
  <video id="Video1" class="bgvid back" autoplay="false" muted="muted" preload="auto" loop>
      <source src="http://shortcodelic1.manuelmasiacsasi.netdna-cdn.com/themes/geode/wp-content/uploads/2014/04/milky-way-river-1280hd.mp4.mp4" type="video/mp4">
  </video>
  <div class="inner-container">
    <video id="Video2" class="bgvid inner" autoplay="false" muted="muted" preload="auto" loop>
      <source src="http://shortcodelic1.manuelmasiacsasi.netdna-cdn.com/themes/geode/wp-content/uploads/2014/04/milky-way-river-1280hd.mp4.mp4" type="video/mp4">
    </video>
    {!!Form::open(['method'=>'POST','action'=>'Auth\AuthController@login'])!!}
        <div class="box">
              <h1>Login</h1>
              <div class="form-group">
                {!!Form::text('username',null,['class'=>'form-control','placeholder'=>'Username'])!!}
              </div>
              <div class="form-group">
                {!!Form::input('password','password',null,['class'=>'form-control','placeholder'=>'Password'])!!}
              </div>
              <div class="form-group">
                {!!Form::button('Sign In',['class'=>'form-control','type'=>'submit'])!!}
              </div>
              <div class="col-md-12">
                  <span class="pull-right col-md-4" id='forgot_password' data-toggle="modal" data-target="#reset_modal">Forgot Password?</span>
              </div>
              <p>Not a member? <span id="register_redirect_button" onclick='registerDivShow();'>Sign Up</span></p>
        </div>
    {!!Form::close()!!}
  </div>
</div>
</div>

@if (count($errors->register) > 0)
<div id='errors'>
    
        <div class="alert">
            <ul>
                @foreach ($errors->register->all() as $error)
                    <li class="alert alert-danger">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    
</div>
@endif
<div id="register_div" >
  <div class="vid-container">
  <video id="Video1" class="bgvid back" autoplay="false" muted="muted" preload="auto" loop>
      <source src="http://shortcodelic1.manuelmasiacsasi.netdna-cdn.com/themes/geode/wp-content/uploads/2014/04/milky-way-river-1280hd.mp4.mp4" type="video/mp4">
  </video>
  <div class="inner-container-register">
    <video id="Video2" class="bgvid inner" autoplay="false" muted="muted" preload="auto" loop>
      <source src="http://shortcodelic1.manuelmasiacsasi.netdna-cdn.com/themes/geode/wp-content/uploads/2014/04/milky-way-river-1280hd.mp4.mp4" type="video/mp4">
    </video>
    {!!Form::open(['method'=>'POST','action'=>'Auth\AuthController@register'])!!}
    <div class="box">
        <h1>Sign Up</h1>
        <div class="form-group">
          {!! Form::text('name',null,['class'=>'form-control','placeholder'=>"Please Enter Your Full Name"])!!}
        </div>
        <div class="form-group">
          {!! Form::input('text','email',null,['class'=>'form-control','placeholder'=>"Please Enter your Email ID"])!!}
        </div>
        <div class="form-group">
          {!! Form::text('username',null,['class'=>'form-control','placeholder'=>"Please Choose your Username"])!!}
        </div>
        <div class="form-group">
          {!! Form::input('password','password',null,['class'=>'form-control','placeholder'=>"Please Enter Password"])!!}
        </div>
        <div class="form-group">
          {!! Form::input('password','password_confirmation',null,['class'=>'form-control','placeholder'=>"Please Confirm Password"])!!}
        </div>
        <div class="form-group">
          {!! Form::button('Sign Up',['type'=>'submit'])!!}
        </div>
        <p>Already a member? <span id="login_redirect_button" onclick="loginDivShow();">Sign In</span></p>
    </div>
    {!!Form::close()!!}
  </div>
</div>
</div>

<div class="modal fade" id='reset_modal' tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      @if (count($errors->forgot_password) > 0)
        <div id='errors'>
            
                <div class="alert">
                    <ul>
                        @foreach ($errors->forgot_password->all() as $error)
                            <li class="alert alert-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            
        </div>
      @endif
       {!!Form::open(['method'=>'POST','action'=>'Auth\PasswordController@postEmail'])!!}
      <div class="modal-body">
        <div class="form-group">
         
          {!! Form::input('text','reset_email',null,['class'=>'form-control','placeholder'=>"Please Enter your Email ID"])!!}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      {!!Form::close()!!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('script')
@if (count($errors->register) > 0)
<script>
    $('document').ready(function(){
        $('#login_div').hide();
        $('#register_div').show();
        $('div.alert').delay(2000).slideUp();
    });
</script>
@elseif (count($errors->forgot_password)>0)
<script>
    $('document').ready(function(){
        $('#forgot_password').click();
        $('div.alert').delay(2000).slideUp();
    });
     
</script>
@else
<script>
    $('document').ready(function(){
        $('#register_div').hide();
        $('div.alert').delay(2000).slideUp();
    });
     
</script>
@endif
@endsection