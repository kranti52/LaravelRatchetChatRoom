<?php

namespace App\Listeners;

use App\Events\SocketEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SocketListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SocketEvent  $event
     * @return void
     */
    public function onUpdate()
    {
        
    }
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\SocketEvent',
            'App\Listeners\SocketListener@onUpdate'
        );
    
        
    }
    public function handle(SocketEvent $event)
    {
        //
    }
}
