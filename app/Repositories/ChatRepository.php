<?php

namespace App\Repositories;

use App\Interfaces\ChatInterface;
use App\Models\Channel;
use App\Models\Chat;

class ChatRepository implements ChatInterface
{
    public function getChannel($user_id)
    {
        return Channel::where('sender_id', $user_id)
            ->orWhere('receiver_id', $user_id)
            ->where('archived_by', '!=', $user_id)
            ->orderByDesc('updated_at')
            ->get();
    }

    public function getChatChannels($user_id)
    {
        return Channel::where('sender_id', $user_id)
            ->orWhere('receiver_id', $user_id)
            ->where('archived_by', null)
            ->get();
    }

    public function createChannel($sender_id, $receiver_id )
    {
         // Check if a chat room already exists between the two users
        $chatRoom = Channel::where(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $sender_id)
                ->where('receiver_id', $receiver_id);
        })->orWhere(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $receiver_id)
                ->where('receiver_id', $sender_id);
        })->first();

        if ($chatRoom) {
            // Chat room already exists, return the existing one
            return $chatRoom;
        }
        return Channel::updateOrCreate([
            'name' => env('REDIS_CHANNEL_NAME') . $sender_id . "_" . $receiver_id,
            'sender_id' => $sender_id,
            'sender_type' => User::class,
            'receiver_id' => $receiver_id,
            'receiver_type' => User::class,
        ]);
    }

    public function sendMessage($message_id, $channel_id, $receiver_id, $sender_id, $message, $fileIds = null)
    {
        $message = Chat::create([
            'message_id' => $message_id,
            'channel_id' => $channel_id,
            'sender_id' => $sender_id,
            'sender_type' => User::class,
            'receiver_id' => $receiver_id,
            'receiver_type' => User::class,
            'message' => $message,
        ]);

        if (!empty($fileIds)) {
            $message->files()->attach($fileIds);
        }
        return $message;
    }
   

    public function markAsRead($channel_id, $user_id)
    {
        $chatRoom = Chat::query()
        ->where('channel_id', $channel_id)->where('sender_id', '!=', $user_id)
            ->where('is_read', false)
            ->update(['is_read' => 1]);
    }

    public function getChatMessages($channel_id)
    {
        $chatRoom = Channel::findOrFail($channel_id);
        return $chatRoom->chats;
    }

    public function getArchivedChannels($user_id)
    {
        return Channel::where('sender_id', $user_id)
            ->orWhere('receiver_id', $user_id)
            ->where('archived_by', $user_id)
            ->orderByDesc('updated_at')
            ->get();
    }
}