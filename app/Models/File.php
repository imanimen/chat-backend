<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Mime\Message;

class File extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'mime', 'type', 'disk', 'path'];
    protected $table = 'chat_service_files';
    
    /**
     * Get the messages that reference this file.
     */
    public function messages()
    {
        return $this->belongsToMany(Message::class)->using(MessageFile::class);
    }
}
