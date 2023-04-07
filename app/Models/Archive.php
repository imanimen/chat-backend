<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $table = 'chat_service_archives';
    protected $fillable = [
        'channel_id',
        'user_id'
    ];
    public function archivedByUsers()
    {
        return $this->belongsToMany(Channel::class, 'archived_by_users')->withTimestamps();
    }
}
