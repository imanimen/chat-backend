<?php

namespace App\Listeners;

use App\Events\ChatSentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

class ChatSentListener
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
     * @param  \App\Events\ChatSentEvent  $event
     * @return void
     */
    public function handle(ChatSentEvent $event)
    {

        
    }
    
}
