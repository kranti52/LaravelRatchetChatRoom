<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SocketEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $data=array('power'=>0);
    
    
    CONST EVENT = 'messages';
    CONST CHANNEL = 'messages';
 
    /*public function handle($data)
    {
        $redis = Redis::connection();
        $redis->publish(self::CHANNEL, int($this->data['power'])+int('1'));
    }*/
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data = array('power'=>$this->data['power']+1);/*array(
            'power'=> '10'
        );       */ 
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        //return array(self::EVENT);
        return ['test-channel'];
    }
    
    public function broadcastWith()
    {
        return $this->data;
        /*return [
            'user' => [
                'name' => 'Klark Cent',
                'age' => 30,
                'planet' => 'Crypton',
                'abilities' => 'Bashing'
            ]
        ];*/
    }
}
