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
	uri=uri.split('/');
	uri=uri[0];
	port = port.length == 0 ? '8081' : port;
	
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
		$("#user_list").append('<li id='+username+'>'+name+'('+username+')</li>');
		$("#user_list").scrollTop($("#user_list")[0].scrollHeight);
	}
	function deleteUserName(x)
	{
		var delete_user =document.getElementById(x);
		console.log('#'+x);
		$('#'+x).remove();
	}
	$(document).ready(function(){
		if(window.location.hash) {
			var conn = new WebSocket('ws://'+uri+':'+port);
			 $("#logout_button").click(function() {
	    		var data=JSON.stringify({status:'close',username:userName,name:userFullName});
			    conn.send(data);
			    window.location.href="{{action('Auth\AuthController@logout')}}";
	  		});
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
		        reason="Connection has been closed,Please refresh your window.";
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