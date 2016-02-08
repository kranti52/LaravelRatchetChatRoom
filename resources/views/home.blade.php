


@extends('layout')
@section('title','dashboard')
@section('content')
<div class="pull-right">
    <a href="{{action('Auth\AuthController@logout')}}" id="" class="btn btn-primary">Logout</a>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Chat Room</div>

				<div class="panel-body">
					<ul id="chatMessages">
					</ul>
					<div style="display:table; width: 100%;">
						<span style="display:table-cell; width: 65px;">Write here</span>
						<input style="display:table-cell; width: 100%;"type="text" name="chatText" id="chatText" />
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 pull-right">
			<div class="panel panel-default">
				<div class="panel-heading">Users</div>
				<div class="panel-body" id='users'>
					<ul id="user_list">
						
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
@section('script')
<script>
	window.onload = function() {
	    if(!window.location.hash) {
	        window.location = window.location + '#loaded';
	        window.location.reload();
	    }
	}
	
	var userFullName = "{{ \Auth::user()->name }}";
	var userName = "{{\Auth::user()->username}}";
	var port = "{{$chatPort}}";//
	var uri = "{{ explode(':', str_replace('http://', '', str_replace('https://', '', App::make('url')->to('/'))))[0] }}";
	port=8082;
	uri="chatroom-kranti52.c9users.io";
	port = port.length == 0 ? '9090' : port;
	
	function addMessageToChatBox(username,name,message)
	{
		$("#chatMessages").append('<li id='+username+'>'+name+'('+username+'):'+message+'</li>');
		$("#chatMessages").scrollTop($("#chatMessages")[0].scrollHeight);
	}
	function addPlainMessageToChatBox(message)
	{
		$("#chatMessages").append('<li>'+message+'</li>');
		$("#chatMessages").scrollTop($("#chatMessages")[0].scrollHeight);
	}
	function addUserName(username,name)
	{
		$("#users").append('<li id='+username+'>'+name+'('+username+')</li>');
		$("#users").scrollTop($("#users")[0].scrollHeight);
	}
	function deleteUserName(x)
	{
		var delete_user =document.getElementById(x.trim());
		console.log(x);
		$('#'+x.trim()).remove();
		//delete_user.parentNode.removeChild(delete_user);
//};
		//console.log(x);
		//delete_user.remove();
	}
	$(document).ready(function(){
		if(window.location.hash) {
        
	    	
			var conn = new WebSocket('ws://'+uri+':'+port);
			 $("#logout_button").click(function() {
			 	//alert('working');
	    		var data=JSON.stringify({status:'close',username:userName,name:userFullName});
			    conn.send(data);
			    window.location.href="{{action('Auth\AuthController@logout')}}";
	  		});
			function logout()
			{
				
			}
			conn.onopen = function(e)
			{
				var data=JSON.stringify({status:'open',username:userName,name:userFullName});
			    conn.send(data);
			    addPlainMessageToChatBox("Connection established!");
			    setInterval(function() {
	        		if (conn.bufferedAmount == 0)
	        			var heartBeat=JSON.stringify({status:'ping',username:userName,name:userFullName});
	          			conn.send(heartBeat);
	        		}, 5000 );
			};
			
			conn.onerror= function(e)
			{
				var data=JSON.stringify({status:'close',username:userName,name:userFullName});
			    conn.send(data);
			}
			
			conn.onclose = function (event) {
		        var reason;
		        if (event.code == 1000)
		            reason = "Normal closure, meaning that the purpose for which the connection was established has been fulfilled.";
		        else if(event.code == 1001)
		            reason = "An endpoint is \"going away\", such as a server going down or a browser having navigated away from a page.";
		        else if(event.code == 1002)
		            reason = "An endpoint is terminating the connection due to a protocol error";
		        else if(event.code == 1003)
		            reason = "An endpoint is terminating the connection because it has received a type of data it cannot accept (e.g., an endpoint that understands only text data MAY send this if it receives a binary message).";
		        else if(event.code == 1004)
		            reason = "Reserved. The specific meaning might be defined in the future.";
		        else if(event.code == 1005)
		            reason = "No status code was actually present.";
		        else if(event.code == 1006)
		           reason = "Abnormal error, e.g., without sending or receiving a Close control frame";
		        else if(event.code == 1007)
		            reason = "An endpoint is terminating the connection because it has received data within a message that was not consistent with the type of the message (e.g., non-UTF-8 [http://tools.ietf.org/html/rfc3629] data within a text message).";
		        else if(event.code == 1008)
		            reason = "An endpoint is terminating the connection because it has received a message that \"violates its policy\". This reason is given either if there is no other sutible reason, or if there is a need to hide specific details about the policy.";
		        else if(event.code == 1009)
		           reason = "An endpoint is terminating the connection because it has received a message that is too big for it to process.";
		        else if(event.code == 1010) // Note that this status code is not used by the server, because it can fail the WebSocket handshake instead.
		            reason = "An endpoint (client) is terminating the connection because it has expected the server to negotiate one or more extension, but the server didn't return them in the response message of the WebSocket handshake. <br /> Specifically, the extensions that are needed are: " + event.reason;
		        else if(event.code == 1011)
		            reason = "A server is terminating the connection because it encountered an unexpected condition that prevented it from fulfilling the request.";
		        else if(event.code == 1015)
		            reason = "The connection was closed due to a failure to perform a TLS handshake (e.g., the server certificate can't be verified).";
		        else
		            reason = "Unknown reason";
		       	//var data=JSON.stringify({status:'close',username:userName,name:userFullName});
		       	//conn.send(data);
		       addPlainMessageToChatBox("Connection closed: " + reason);
		    };
			
			conn.onmessage = function(e)
			{
				var data=JSON.parse(e.data);
				if(data.status=='open')
				{
					if(data.username==userName && data.name==userFullName)
					{
						data.online_users.forEach(function(value){
							addUserName(value.username,value.name);
						});
						addUserName(data.username,'Me');
					}
					else
					{
						addUserName(data.username,data.name);
					}
						
						data.content.forEach(function(value){
							if(value.username==userName && value.name==userFullName)
							{
								addMessageToChatBox(value.username,'Me',value.message_contents);
							}
							else
							{
								addMessageToChatBox(value.username,value.name,value.message_contents);
							}
							
						});
						
					//}
				}
				if(data.status=='close')
				{
					deleteUserName(data.username);
				}
				if(data.status=='message')
				{
					addMessageToChatBox(data.username,data.name,data.content);
				}
				if(data.status=='pong')
				{
					
				}
				
				//addMessageToChatBox(data.name);
	
			    
			};
			$('#chatText').keyup(function(e){
				if (e.keyCode == 13) // enter was pressed
				{
					var message = $(this).val();
					var data=JSON.stringify({status:'message',username:userName,name:userFullName,content:message});
					conn.send(data);
					addMessageToChatBox(userName,'Me',message);
					$(this).val("");
				}
			});
		}
	});
</script>
@endsection
