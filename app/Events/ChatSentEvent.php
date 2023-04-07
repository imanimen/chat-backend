<?php

namespace App\Events;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChatSentEvent extends Event implements ShouldBroadcastNow
{
    use InteractsWithQueue, SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */

     public $sender;
     public $receiver;
     public $message;
     public $message_id;
    public function __construct( $sender, $receiver, $message, $message_id )
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->message = $message;
        $this->message_id = $message_id;
        // TODO: change this queue worker
        // $this->queue = "realtime"; 
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat_service_' . 'sender_' . $this->sender . '_receiver_' . $this->receiver);
    }

    public function broadcastWith()
    {
        return [
            "data" => [
                "message" => [
                    "message_id" => $this->message_id,
                    "text" => $this->message,
                    "date" => Carbon::now()->format('Y-m-d H:i:s')
                ],
                "from" => [
                    "id" => $this->sender,
                    "type" => User::class,
                ],
            ],
            "message" => [],
            "errors" => [],
            "code" => 200
        ];
    }
    

}
