# LaravelRatchetChatRoom
##Laravel
Laravel is an open source web application framework for producing web applications.This open-source framework complies with model-view-controller architectural pattern.
Its convenience of use, modular packaging system and sophistication have taken the PHP Community by storm. 
Several developers have currently relied on providing Laravel development services as a result of its high readability and rich-features. 
One vital facet of using Laravel is that the developers will not locate the issue of spaghetti coding and are offered a hassle-free syntax.
[Laravel Documentation] (https://laravel.com/docs/5.2)

##Ratchet
Ratchet is a loosely coupled PHP library providing developers with tools to create real time, bi-directional applications between clients and servers over WebSockets.
[Ratchet Documentation] (http://socketo.me/docs/)

##Functionalities
- Register
- Login
- Forgot Password
- ChatRoom
- Logout

##Requirements
- Composer
- Database(mysql)
- npm
- gulp

##Usage
###For login,register,forgot password
I have made just few changes in laravel Illuminate library methods for these purpose.

###For Chatroom
####Server Side:
Create [Console Command] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Console/Commands/ChatServer.php) to start a chat server on specific port.
I have created [application logic] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php) using Ratchet.
Command will launch [application logic] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php) that is using Ratchet for connecting users and chat by using Ratchet default methods.
  - [onOpen] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L10)
  - [onMessage] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L14)
  - [onClose] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L67)
  - [onError] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L79)

Start chat server by command name.For eg: 

Command name is chat:start

Then you will start chat server like this-

php artisan chat:start 

I have stored [chat] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L59) in Database , stored all [active users] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L37) in chatroom and [Change active users data] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L71) when any user disconnect from chat server.

You can keep track of users by their resource id and information of users can be fetched from database based on resource id.

####Client side:
You can connect users to chat server using [html websocket] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/resources/views/home.blade.php#L114) on client side.
Create [onopen] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/resources/views/home.blade.php#L120),[onmessage] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/resources/views/home.blade.php#L144),[onclose] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/resources/views/home.blade.php#L138),[onerror] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/resources/views/home.blade.php#L132) method in your script which well be handled by server side [onOpen] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L10),[onMessage] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L14),[onClose] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L67),[onError] (https://github.com/kranti52/LaravelRatchetChatRoom/blob/master/app/Classes/Sockets/Chat.php#L79) methods respectively.

Fork this repository and make your own chatroom.
