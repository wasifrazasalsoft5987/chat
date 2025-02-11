<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public const PRIVATE = "private";
    public const GROUP = "group";

    protected $fillable = [
        'type',
        'name',
        'image',
        'created_by'
    ];

    protected $with = ['users', 'messages', 'setting'];

    // Relations
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function setting()
    {
        return $this->hasOne(ChatSetting::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_users')->withPivot('is_admin');
    }
    
    // public function users()
    // {
    //     return $this->hasMany(ChatUser::class);
    // }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
