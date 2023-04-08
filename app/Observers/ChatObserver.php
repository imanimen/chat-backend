<?php

namespace App\Observers;

use App\Models\Channel;

trait ChatObserver
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($chat) {
            $channel_id = $chat->channel_id;
            $channel = Channel::find($channel_id);
            $channel->update([
                'last_message' => $chat
            ]);
        });

        static::updated(function ($chat) {

        });

        static::deleted(function ($chat) {

        });

    }
}