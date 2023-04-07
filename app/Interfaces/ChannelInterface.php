<?php

namespace App\Interfaces;

interface ChannelInterface
{
    public function subscribe($channelName, $userId);
    public function unsubscribe($channelName, $userId);
    public function publish($channelName, $message);
    
}