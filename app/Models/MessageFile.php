<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Mime\Message;

class MessageFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat_service_message_file';

    protected $fillable = [
        'message_id', 'file_id'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
