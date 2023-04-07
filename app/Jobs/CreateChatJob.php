<?php

namespace App\Jobs;

use App\Repositories\ChatRepository;

class CreateChatJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $sender_id;
    public $receiver_id;
    public $channel_id;
    public $message_id;
    public $message;
    public $file_ids;
    public function __construct( $message_id, $sender_id, $receiver_id, $message, $file_ids )
    {
        //
        // dd($this->sender_id = $sender_id);
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->message = $message;
        $this->file_ids = $file_ids;
        $this->message_id = $message_id;
        // $this->queue = "default";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $chat = app()->make(ChatRepository::class);
        $channel = $chat->createChannel($this->sender_id, $this->receiver_id);
        $chat->sendMessage($this->message_id, $channel->id, $this->receiver_id, $this->sender_id, $this->message, $this->file_ids = null);
    }
}
