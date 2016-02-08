<?php 
namespace App\Classes\Sockets;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
class Chat implements MessageComponentInterface {
    protected $clients;
    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        //$this->clients->send($username);
        echo "New connection! ({$conn->resourceId})\n";
    }
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $data=json_decode($msg);
        if($data->status=='ping')
        {
            /*$user_present=\App\ChatOnlineUser::where('connection_resource_id','=',$from->resourceId)->firstOrFail();
            if(count($user_present))
            {
                
                $this->clients->detach($from);
            }
            else
            {*/
                $data->status=='pong';
                $from->send(json_encode($data));
            //}
            
        }
        
        if($data->status=='open')
        {
            $current_user=\App\ChatOnlineUser::where('username','=',$data->username)->first();
            print_r(empty((array)$current_user));
            if(!empty($current_user))
            {
                \App\ChatOnlineUser::where('username','=',$data->username)->delete();
            }
            $chat_user_data=array('username'=>$data->username,'name'=>$data->name,'connection_resource_id'=>$from->resourceId);
            $online_users=\App\ChatOnlineUser::all();
            $data->online_users=$online_users->toArray();
            \App\ChatOnlineUser::create($chat_user_data);
            $messages=\App\Message::all();
            $data->content=$messages->toArray();
            foreach ($this->clients as $client) {
                //if ($from !== $client) {
                    $client->send(json_encode($data));
                //}
            }
        }
        
        if($data->status=='close')
        {
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send($msg);
                }
            }
        }
        
        if($data->status=='message')
        {
            $message_data=array('username'=>$data->username,'name'=>$data->name,'message_contents'=>$data->content);
            \App\Message::create($message_data);
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send($msg);
                }
            }
        }
    }
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        $disconnected_user=\App\ChatOnlineUser::where('connection_resource_id','=',$conn->resourceId)->first();
        $data=array('status'=>'close','username'=>$disconnected_user->username,'name'=>$disconnected_user->name);
        print_r($data);
        \App\ChatOnlineUser::where('connection_resource_id','=',$conn->resourceId)->delete();
        foreach ($this->clients as $client) {
                //if ($from !== $client) {
                    $client->send(json_encode($data));
                //}
            }
        echo "Connection {$conn->resourceId} has disconnected\n";
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
    
    /*public function send($status,$data)
    {
        
    }
    
    public function getAllMessages()
    {
        
    }
    
    public function onlineUsers()
    {
        
    }*/
}