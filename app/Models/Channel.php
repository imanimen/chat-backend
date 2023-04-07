<?php

namespace App\Models;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'chat_service_channels';
    protected $fillable = [
        'name',
        'sender_type',
        'sender_id',
        'receiver_type',
        'receiver_id',
        'last_message'
    ];

    protected function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public function archivedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_service_archives')
            ->withTimestamps();
    }
}