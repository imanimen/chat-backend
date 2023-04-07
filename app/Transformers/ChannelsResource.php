<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => env('REDIS_CHANNEL_NAME').'sender_' . $this->sender_id . '_receiver_' . $this->receiver_id,
            'type' => $this->sender_type,
            'is_archived' => $this->is_archived,
            'last_message' => $this->last_message
        ];
    }

}
