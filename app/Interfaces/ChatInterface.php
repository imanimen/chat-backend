<?php

namespace App\Interfaces;

interface ChatInterface
{
    public function getChatChannels($user_id);
    public function getChannel($channel_id);
    public function createChannel($sender_id, $receiver_id);
    public function sendMessage($sendMessage, $channel_id, $receiver_id, $sender_id, $message, $fileIds = null);
    public function markAsRead($channel_id, $userId);
    public function getChatMessages($channel_id);
}