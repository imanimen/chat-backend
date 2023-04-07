<?php

namespace App\Jobs;

use App\Repositories\ChatRepository;

class MarkMessagesAsReadJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user_id;
    public $channel_id;
    public function __construct( $user_id, $channel_id )
    {
        $this->user_id = $user_id;
        $this->channel_id = $channel_id;
        $this->queue = "default";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chat = app()->make(ChatRepository::class);
        $chat->markAsRead($this->channel_id, $this->user_id);
    }
}
