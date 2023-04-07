<?php

namespace App\Models;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chat_service_chats';
    protected $fillable = [
        'channel_id',
        'message_id',
        'message',
        'sender_type',
        'sender_id',
        'receiver_type',
        'receiver_id',
        'is_read'
    ];

    protected function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
    
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'chat_service_message_file')
            ->withTimestamps();
    }
}