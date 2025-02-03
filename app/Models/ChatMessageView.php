<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_message_id',
        'user_id',
    ];

    // Relations
    public function message()
    {
        return $this->belongsTo(ChatMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
